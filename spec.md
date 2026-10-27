# spec.md

Спецификация проекта TeachersSelector: стек, архитектура и практики. Сверяйся с этим файлом при выполнении любой задачи.

## Стек

- **Язык/фреймворк:** PHP 8.3, Symfony 7.2 (framework, security, form, validator, messenger, mailer, notifier, serializer, twig, http-client).
- **БД:** PostgreSQL, Doctrine ORM 3 / DBAL 3, Doctrine Migrations, `beberlei/doctrineextensions`.
- **Очереди:** RabbitMQ через `symfony/amqp-messenger` (транспорт `async`, `MESSENGER_TRANSPORT_DSN`).
- **Кэш:** Redis (`predis`).
- **Платежи:** Stripe (`stripe/stripe-php`, `Infrastructure/Services/StripeService`).
- **Чат:** `PersonalChatBundle/` (path-репозиторий), OpenSwoole + `ratchet/pawl`, WebSocket-сервер.
- **Окружение:** Docker (Nginx, два php-fpm — `fpm1` и `fpm2`, PostgreSQL, RabbitMQ, Grafana).
- **Мониторинг/дашборды:** Grafana 13.3.0 (`http://localhost:3000`), источник данных PostgreSQL и дашборд создаются provisioning'ом из `docker/grafana/`; JSON дашбордов лежат в `docker/grafana/dashboards/`, правки делай в файлах, а не в UI (`allowUiUpdates: false`).
- **Dev:** PHPUnit 12, `zenstruck/foundry`, `doctrine-fixtures-bundle`, `maker-bundle`, `browser-kit`, `css-selector`, `web-profiler-bundle`.
- **Деплой:** GitHub Actions (`.github/workflows/deploy.yml`), по SSH: git pull / composer install / обновление схемы.

## Архитектура

Слоистая (DDD-подобная) структура в `src/`, namespace `App\`.

### Domain/
Сущности (`Entity`), value objects (`ValueObject/<Контекст>`), `Enums`, интерфейсы репозиториев (`*RepositoryInterface`), интерфейсы сервисов, `FactoryInterface`, `CreateDTOInterface`, интерфейсы шин (`Bus/Command`, `Bus/Query`). **Не зависит** от Application и Infrastructure.

### Application/<Контекст>/
`UseCase/`, `DTO/` (`Create*DTO`, `Response*DTO`), `Factory/`. Для платежей — CQRS: `Payment/Command` (`MakePaymentCommand` + handler), `Payment/Query` (`GetPaymentQuery`, handler, `*QueryResponse`). Зависит только от Domain (через интерфейсы).

### Infrastructure/
- `Http/<Контекст>/Controller` — контроллеры;
- `Repository` — Doctrine-репозитории;
- `Form`, `Security`, `Services` (Stripe);
- `Bus` — in-memory реализации шин и `HandlerBuilder`;
- `DataFixtures`, `Factory` (Foundry).

### Шины команд и запросов
- Хендлеры реализуют `CommandHandler` / `QueryHandler`; теги `internal.command_handler` / `internal.query_handler` навешиваются через `_instanceof` в `config/services.yaml`.
- `HandlerBuilder` строит карту «сообщение → хендлеры» по типу первого параметра `__invoke`, поэтому `__invoke` должен принимать **ровно один** параметр — класс команды/запроса.
- Async-транспорт (AMQP) настроен отдельно в `config/packages/messenger.yaml`.

### Архитектурные правила (Deptrac)
Границы слоёв проверяются `deptrac/deptrac` (конфиг `deptrac.yaml`, известные старые нарушения — `deptrac.baseline.yaml`). Запуск в `fpm1`: `composer deptrac`.
- `Domain` → только Doctrine (атрибуты маппинга), Symfony (Security/Validator), PersonalChat; **не** зависит от Application и Infrastructure.
- `Application` → только `Domain`.
- `Infrastructure` → `Domain`, `Application` и внешние библиотеки.
- Анализируются типы `class`, `function` и `use`: запрещённый импорт ловится даже без использования класса. В IDE нарушения не подсвечиваются — проверка только через `composer deptrac` (локально и в CI).
- Новое нарушение роняет проверку: исправь код, а не baseline. Baseline можно только сокращать (по мере рефакторинга удаляй записи; пересоздание — `vendor/bin/deptrac analyse --formatter=baseline --output=deptrac.baseline.yaml`, только по согласованию).
- Известный техдолг в baseline: `repositoryClass` в сущностях Domain ссылается на Infrastructure; `PaymentServiceInterface` использует Application DTO; `MakePaymentCommandHandler` и `ResponseTeacherDTO` используют Doctrine.

### Регистрация сервисов
Doctrine-репозитории регистрируются в `services.yaml` явно (тег `doctrine.repository_service`, `public: true`) — при добавлении нового репозитория проверь, нужна ли такая регистрация.

## Практики

- `declare(strict_types=1)`, типизация параметров и возвращаемых значений, constructor promotion, `readonly`, enum'ы.
- Следуй стилю соседнего кода: именование, плотность комментариев, структура.
- Границы слоёв: Domain ← Application ← Infrastructure; зависимости направлены к Domain, используются интерфейсы.
- Контроллеры тонкие: только маппинг HTTP ↔ use case / шина.
- Валидация — через Validator на DTO/формах; доменные инварианты — в сущностях и value objects.
- Запросы к БД — только в репозиториях; без N+1; `flush()` не в цикле; транзакции на уровне use case.
- Сущности не отдаются наружу — используй DTO.
- Схема БД меняется только миграциями; проверка — `doctrine:schema:validate`.
- Тяжёлые и внешние операции (письма, уведомления, интеграции) — асинхронно через Messenger; хендлеры идемпотентны.
- Платежи: идемпотентность, транзакции, обработка ошибок Stripe.
- Безопасность: CSRF, права доступа (voters / `access_control`), секреты только в `.env` (шаблон `.env.example`).
- Не расширяй скоуп задачи; о замеченных проблемах сообщай отдельно.

## Тестирование

- Каталоги: `tests/Unit`, `tests/Integration`, `tests/Application` (WebTestCase). Данные — Foundry-фабрики и фикстуры.
- Запуск внутри контейнера `fpm1`: `php bin/phpunit`; один тест — `php bin/phpunit tests/Unit/Path/To/FooTest.php` или `--filter testName`.
- `phpunit.dist.xml` падает на deprecation / notice / warning.
- **Обязательное правило:** после написания кода всегда проверяй работоспособность функционала автотестами в соответствии с заданием. Добавь или обнови тесты, покрывающие требования задачи, и прогони их (затронутые тесты; при изменении общих частей — весь набор). Задача не считается выполненной при падающих тестах. Дополнительно после изменений в `src/` запускай `composer deptrac`. Если запустить тесты нельзя — прямо сообщи об этом.

## Команды (внутри `fpm1`: `docker exec -it fpm1 bash`)

- Окружение: `docker compose up --build -d`
- Зависимости: `composer i`
- Миграции: `php bin/console doctrine:migrations:migrate`, `make:migration` / `doctrine:migrations:diff`, `doctrine:schema:validate`
- Фикстуры: `php bin/console doctrine:fixtures:load`
- Роуты: `php bin/console debug:router`
- Архитектурные правила: `composer deptrac`
- Чат: `personal-chat:ws-server-start`, `messenger:consume personalChats -vv`, `personal-chat:sync-participants`