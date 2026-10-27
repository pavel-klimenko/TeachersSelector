# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Обзор

TeachersSelector — платформа подбора преподавателей (рейтинг, опыт, ставка, экспертиза, формат обучения). Стек: PHP 8.3, Symfony 7.2, Doctrine ORM + PostgreSQL, RabbitMQ (Messenger), Redis (predis), Stripe, Nginx, Docker. Отдельный бандл личного чата лежит в `PersonalChatBundle/` (подключён как path-репозиторий в `composer.json`, Swoole WebSocket-сервер).

## Обязательные правила

- Перед выполнением любой задачи прочитай `spec.md` в корне (стек, архитектура, практики) и сверяйся с ним. При расхождении кода или задачи со `spec.md` — сообщи об этом.
- После написания кода всегда проверяй работоспособность функционала автотестами в соответствии с заданием: добавь/обнови тесты в `tests/{Unit,Integration,Application}` и запусти `php bin/phpunit` в контейнере `fpm1`. Не завершай задачу с падающими тестами; если запустить тесты нельзя — прямо скажи об этом.

## Команды

Все команды выполняются внутри php-fpm контейнера (`docker exec -it fpm1 bash`).

- Запуск окружения: `docker compose up --build -d`
- Зависимости: `composer i`
- Миграции: `php bin/console doctrine:migrations:migrate`; новая — `php bin/console make:migration` или `doctrine:migrations:diff`; проверка — `doctrine:schema:validate`
- Тестовые данные: `php bin/console doctrine:fixtures:load`
- Тесты: `php bin/phpunit`; один тест — `php bin/phpunit tests/Unit/Path/To/FooTest.php` или `--filter testName`. Конфиг `phpunit.dist.xml` падает на deprecation/notice/warning.
- Архитектурные правила (Deptrac): `composer deptrac`; конфиг `deptrac.yaml`, baseline `deptrac.baseline.yaml`
- Grafana: `docker compose up -d grafana`, UI `http://localhost:3000` (логин/пароль из `GRAFANA_ADMIN_USER`/`GRAFANA_ADMIN_PASSWORD` в `.env`); конфигурация — `docker/grafana/`. Первый старт ~5–9 минут (миграции SQLite).
- Роуты: `php bin/console debug:router`
- Чат: `php bin/console personal-chat:ws-server-start` (WebSocket), `php bin/console messenger:consume personalChats -vv` (консьюмер), `personal-chat:sync-participants` (синхронизация User ↔ участники чата). Полная установка бандла описана в `README.md`.
- Деплой: GitHub Actions (`.github/workflows/deploy.yml`) на каждый push по SSH делает git pull / composer install / обновление схемы на проде.

## Архитектура

Слоистая (DDD-подобная) структура в `src/` с namespace `App\`:

- `Domain/` — сущности, value objects, enum'ы, интерфейсы репозиториев, доменные сервисы/фабрики и **интерфейсы шин** (`Domain/Bus/{Command,Query}`).
- `Application/<Контекст>/` — use case'ы, DTO, фабрики, а для платежей — CQRS: `Payment/Command` (`MakePaymentCommand` + handler) и `Payment/Query`.
- `Infrastructure/` — реализации: контроллеры (`Http/`), Doctrine-репозитории, формы, Stripe (`Services/StripeService`), фикстуры, Foundry-фабрики, шины.

### Шины команд/запросов

`Infrastructure/Bus/{Command,Query}` содержит in-memory реализации на базе Symfony `MessageBus`. Хендлеры, реализующие `CommandHandler`/`QueryHandler`, автоматически помечаются тегами `internal.command_handler` / `internal.query_handler` через `_instanceof` в `config/services.yaml`. `HandlerBuilder` по типу первого параметра `__invoke` строит карту «сообщение → хендлеры». Новый хендлер должен иметь `__invoke` ровно с одним параметром (классом команды/запроса). Отдельно в `config/packages/messenger.yaml` настроен async-транспорт (AMQP).

### Прочее

- Репозитории Doctrine в `services.yaml` регистрируются явно (тег `doctrine.repository_service`, `public: true`) — при добавлении нового репозитория проверь, нужна ли такая регистрация.
- Тесты разделены на `tests/Unit`, `tests/Integration`, `tests/Application`.
- Секреты и параметры — в `.env` (шаблон `.env.example`); для чата нужны `CHAT_WEB_SOCKET_HOST/PORT`, `CHAT_SERVER_HOST`, `WS_SIGN_SECRET`.