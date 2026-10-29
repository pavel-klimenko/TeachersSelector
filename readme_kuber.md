# Kubernetes в TeachersSelector — инструкция по управлению

Локальный запуск проекта в Kubernetes (kind + Helm). Docker Compose остаётся основным способом разработки;
Kubernetes-часть лежит отдельно в `deploy/` и production-образах в `docker/*/Prod*.Dockerfile`.

## 1. Как это устроено

```
                    ┌───────────────────────── кластер (kind: ts) ─────────────────────────┐
 браузер ──Ingress──►  Service ts-web ──► Pod web x2: [nginx :80] ─fastcgi:9000─► [php-fpm]  │
                    │                              │ сессии/кэш              │ SQL    │ AMQP │
                    │                              ▼                         ▼        ▼      │
                    │                          ts-redis                  ts-pgsql  ts-rabbitmq
                    │  Pod worker: messenger:consume async personalChats ──────────┘  ▲      │
                    │  Pod chat:   personal-chat:ws-server-start (WebSocket :8080) ───┘ HTTP │
                    │  Job migrations: doctrine:migrations:migrate (при install/upgrade)     │
                    └─────────────────────────────────────────────────────────────────────────┘
```

| Компонент | Что делает | Реплики |
|---|---|---|
| `web` | nginx + php-fpm в одном поде (общаются по `127.0.0.1:9000`) | 2 (масштабируется) |
| `worker` | обработчик очередей Messenger (`async`, `personalChats`) | 1+ |
| `chat` | WebSocket-сервер чата (Swoole). Подписки хранятся **в памяти процесса** | **строго 1** |
| `migrations` | Job-хук: миграции БД перед выкатом | одноразово |
| `ts-pgsql`, `ts-rabbitmq`, `ts-redis` | инфраструктура **только для dev** (без постоянного хранилища) | 1 |

Один и тот же PHP-образ (`teachers-selector/php`) запускается в разных ролях — отличается только команда.
Конфигурация приходит из ConfigMap (не секретное) и Secret (секретное) как переменные окружения.

## 2. Файлы

| Файл | Назначение |
|---|---|
| `docker/php/Prod.Dockerfile` | Production-образ: PHP-FPM + расширения + код + `vendor` (без dev) + прогретый кэш Symfony |
| `docker/nginx/Prod.Nginx.Dockerfile`, `docker/nginx/prod.conf` | Образ nginx со статикой `public/`, gzip, `/healthz`, проксирование в php-fpm |
| `docker/php/conf.d/prod-php.ini` | OPcache без проверки timestamps, `expose_php=0` |
| `.dockerignore` | Не пускает в образ `.env`, `var`, `vendor`, тесты и т.д. |
| `deploy/kind/kind-config.yaml` | Конфиг локального кластера (нода 1.28.15, etcd без fsync) |
| `deploy/helm/teachers-selector/` | Helm-чарт (шаблоны в `templates/`) |
| `values.yaml` | Значения по умолчанию (ресурсы, реплики, FPM, ingress) |
| `values-kind.yaml` | Переопределения для kind: инфраструктура в кластере, **тестовые** секреты |

Сессии и кэш приложения хранятся в Redis (`REDIS_URL`) — иначе при нескольких репликах пользователя разлогинивало бы.

## 3. Требования

`docker`, `kubectl`, `kind` (>= 0.33), `helm` (>= 3.14). Минимум ~3 ГБ свободной RAM для WSL/Docker.

## 4. Первый запуск (пошагово)

Все команды — из корня проекта.

```bash
# 1. Собрать образы (php собирается долго: компиляция openswoole, 5-15 минут)
docker build -f docker/php/Prod.Dockerfile       -t teachers-selector/php:dev .
docker build -f docker/nginx/Prod.Nginx.Dockerfile -t teachers-selector/nginx:dev .
# образ с dev-зависимостями для загрузки тестовых данных (только dev/kind; слой base берётся из кэша)
docker build -f docker/php/Prod.Dockerfile --target fixtures -t teachers-selector/php-fixtures:dev .

# 2. Создать кластер
kind create cluster --name ts --config deploy/kind/kind-config.yaml

# 3. Загрузить образы в кластер (нода не ходит в Docker Hub)
kind load docker-image teachers-selector/php:dev teachers-selector/nginx:dev teachers-selector/php-fixtures:dev --name ts

# 4. Образ RabbitMQ (kind load не умеет мультиплатформенные образы, поэтому через save)
docker pull rabbitmq:3-management
docker save --platform linux/amd64 -o /tmp/rabbitmq.tar rabbitmq:3-management
kind load image-archive /tmp/rabbitmq.tar --name ts && rm /tmp/rabbitmq.tar
# то же для postgres:14.1-alpine и redis:7-alpine, если нода не может их скачать

# 5. Установить чарт (миграции выполнятся автоматически)
helm install ts deploy/helm/teachers-selector -f deploy/helm/teachers-selector/values-kind.yaml --timeout 8m

# 6. Проверить
kubectl get pods
```

Ожидаемо: `web` — `2/2 Running` (x2), `worker`, `chat`, `pgsql`, `redis`, `rabbitmq` — `1/1 Running`.
Job `migrations` после успеха удаляется сам (hook-delete-policy).

## 5. Доступ к приложению

```bash
kubectl port-forward svc/ts-web 8096:80      # сайт:       http://localhost:8096
kubectl port-forward svc/ts-chat 8080:8080   # WebSocket:  ws://localhost:8080
kubectl port-forward svc/ts-rabbitmq 15672   # RabbitMQ UI: http://localhost:15672 (guest/guest)
```

Проверка: `curl localhost:8096/health-check` → `{"status":"ok"}`.
Тестовые данные загружает Job `ts-fixtures` (хук post-install/post-upgrade, после миграций), он включён в
`values-kind.yaml` (`fixtures.enabled: true`). Он выполняет `doctrine:fixtures:load`, то есть **стирает БД и заполняет заново** при каждом
`helm install`/`helm upgrade`. Чтобы обновить релиз, не трогая данные: `helm upgrade ... --set fixtures.enabled=false`.
Перезагрузить тестовые данные: `helm upgrade ts deploy/helm/teachers-selector -f deploy/helm/teachers-selector/values-kind.yaml`.
В prod-образе команды `doctrine:fixtures:load` нет (бандл только для dev/test), а чарт не даёт включить фикстуры без `infra.enabled=true`.

## 6. Повседневное управление

```bash
kubectl get pods,svc,deploy                           # состояние
kubectl logs deploy/ts-worker -f                      # логи воркера (ts-chat, ts-web -c php-fpm / -c nginx)
kubectl describe pod <pod>                            # причина проблем со стартом
kubectl exec -it deploy/ts-web -c php-fpm -- bash     # консоль в поде
kubectl exec deploy/ts-web -c php-fpm -- php bin/console <команда>

kubectl scale deploy/ts-web --replicas=3              # ручное масштабирование
kubectl scale deploy/ts-worker --replicas=2           # больше обработчиков очереди
# chat НЕ масштабировать: подписки в памяти процесса

kubectl rollout restart deploy/ts-web                 # перезапуск без простоя
kubectl rollout status deploy/ts-web
```

## 7. Обновление кода

```bash
docker build -f docker/php/Prod.Dockerfile -t teachers-selector/php:v2 .
docker build -f docker/nginx/Prod.Nginx.Dockerfile -t teachers-selector/nginx:v2 .
kind load docker-image teachers-selector/php:v2 teachers-selector/nginx:v2 --name ts

helm upgrade ts deploy/helm/teachers-selector -f deploy/helm/teachers-selector/values-kind.yaml \
  --set image.php.tag=v2 --set image.nginx.tag=v2
```

Порядок: сначала Job `migrations` (pre-upgrade), затем rolling-update `web` (`maxUnavailable: 0`, без простоя).
Откат: `helm history ts` → `helm rollback ts <REVISION>` (миграции БД назад не откатываются).

## 8. Настройка производительности (`values.yaml`)

| Параметр | Зачем |
|---|---|
| `web.resources.*`, `worker.resources`, `chat.resources` | requests — для планировщика и HPA; limits по памяти — защита ноды |
| `web.fpm.maxChildren` | воркеров php-fpm на под; правило: `maxChildren × ~40 МБ <= limits.memory php` |
| `web.fpm.maxRequests` | перезапуск воркера после N запросов (защита от утечек) |
| `web.autoscaling.enabled` | HPA по CPU (нужен metrics-server, см. ниже) |
| `podDisruptionBudget` | не гасить обе реплики web при обслуживании ноды |

Применить изменение: поправить значения и выполнить `helm upgrade` (ConfigMap с настройками FPM
подхватывается через перезапуск подов — `checksum`-аннотации уже перезапускают worker/chat, для web: `kubectl rollout restart deploy/ts-web`).

## 9. Production (не kind)

1. Отключить `infra.enabled`, использовать внешние PostgreSQL/RabbitMQ/Redis (управляемые сервисы или операторы).
2. Секреты — в отдельном Secret: `kubectl create secret generic ts-secrets --from-literal=APP_SECRET=... \
   --from-literal=DATABASE_URL=... --from-literal=MESSENGER_TRANSPORT_DSN=... --from-literal=REDIS_URL=... \
   --from-literal=WS_SIGN_SECRET=... --from-literal=STRIPE_SECRET_KEY=...`, затем `--set secrets.existingSecret=ts-secrets`.
   **Не используйте** секреты из `values-kind.yaml`.
3. Образы — в реестр (GHCR и т.п.), `image.*.repository/tag`, `image.pullSecrets`.
4. Ingress: `ingress.enabled=true`, `ingress.host`, `ingress.chatHost`; в кластере нужен ingress-controller и `config.CHAT_WEB_SOCKET_HOST`.
5. Включить `web.autoscaling.enabled` (нужен metrics-server).

## 10. Остановка и удаление

```bash
helm uninstall ts            # удалить релиз
kind delete cluster --name ts   # удалить кластер целиком
```

## 11. Известные проблемы и решения

| Симптом | Причина / решение |
|---|---|
| `kind create cluster` падает: `unable to create ClusterRoleBinding ... connection refused` | kubeadm >= 1.29 ждёт API-сервер ~30 с. На слабой машине не успевает. Поэтому в `kind-config.yaml` закреплена нода `v1.28.15` |
| `ImagePullBackOff` для rabbitmq/postgres/redis | Нода kind не достаёт Docker Hub. Загрузите образ вручную (шаг 4) |
| `kind load` → `content digest ... not found` | Мультиплатформенный образ при Docker с containerd-хранилищем. Используйте `docker save --platform linux/amd64` + `kind load image-archive` |
| worker в `CrashLoopBackOff` | Нет соединения с RabbitMQ: проверьте `kubectl get pod -l app=ts-rabbitmq` и `kubectl logs deploy/ts-worker --previous` |
| `kubectl top` → `Metrics API not available` | Не установлен metrics-server (нужен и для HPA) |
| Кластер/сборки тормозят, swap | WSL упирается в память (`~/.wslconfig`: `memory=4GB`). Остановите лишнее (`docker compose stop`) или увеличьте лимит |
| `There are no commands defined in the "doctrine:fixtures" namespace` | Фикстуры запускают в prod-образе, где dev-бандлов нет. Используйте Job `ts-fixtures` (образ `teachers-selector/php-fixtures`, стадия `fixtures`) |
| БД пустая после перезапуска ноды kind / Docker | Postgres в kind без постоянного хранилища (`emptyDir`). Выполните `helm upgrade` (миграции + фикстуры) |
| Пользователя «выкидывает» между запросами | Сессии должны быть в Redis: проверьте `REDIS_URL` и `kubectl exec deploy/ts-redis -- redis-cli --scan` |

## 12. Что не сделано / не проверено

- CI/CD: `.github/workflows/deploy.yml` по-прежнему деплоит по SSH. Сборка образов и `helm upgrade` в GitHub Actions не настроены.
- Не проверялись: Ingress, HPA, обработка реального сообщения из очереди, вход реального пользователя и сам чат.
- Масштабирование чата выше 1 реплики требует переноса подписок в Redis pub/sub.