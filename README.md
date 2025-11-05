## 📂 Структура проекта

```
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── vendor/
├── docker/
│   ├── common/                     # Общие настройки для всех окружений
│   │   └── php-fpm/
│   │       ├── Dockerfile          # Базовый образ PHP-FPM
│   │       ├── entrypoint.sh       # Точка входа (создаёт /var/run/php, запускает php-fpm)
│   │       └── pool.d/             # Конфигурация PHP-FPM пулов
│   │           ├── www.conf        # Основной пул (user/group, pm, базовые настройки)
│   │           └── zzz-override.conf # Переопределяет default (zz-docker.conf), включает сокет /var/run/php/php-fpm.sock
│
│   ├── development/                # Конфигурация для локальной разработки
│   │   └── nginx/
│   │       ├── Dockerfile          # Образ Nginx
│   │       └── nginx.conf          # Конфигурация Nginx (fastcgi_pass unix:/var/run/php/php-fpm.sock)
│
│   └── production/                 # Продакшн-окружение (другие параметры, кеш, supervisor, opcache)
│       └── ...
├── docker-compose.dev.yml
└── Makefile
```

---

## 🧱 Сервисы

| Сервис | Образ | Назначение |
|---------|--------|-------------|
| **php** | custom (php:8.2-fpm-alpine) | Выполнение Laravel и PHP-кода |
| **nginx** | nginx:1.27-alpine | HTTP-сервер, отдаёт статику и проксирует `.php` в php-fpm |
| **db** | mysql:8.4 | СУБД MySQL (в dev монтируется volume `db_data`) |
| **redis** | redis:7-alpine | Кеш, очереди, сессии |
| **frontend** | (локальный Node.js) | Vite dev-server (`npm run dev`) |

---

## ⚙️ Требования

- Docker Desktop ≥ 4.30  
- Node.js ≥ 20 (для локального фронта)  
- Composer ≥ 2
- MacOS / Linux (для Windows WSL2)

---

## 🪄 Первый запуск проекта (полная инициализация)

```bash
# 1. Клонируем репозиторий
git clone git@github.com:denx-b/otus-laravel.git
cd otus-laravel

# 2. Создаём .env из шаблона
cp .env.example .env

# 3. Обновляем настройки подключения к БД под Docker
sed -i '' \
  -e 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' \
  -e 's/^# DB_HOST=.*/DB_HOST=db/' \
  -e 's/^# DB_DATABASE=.*/DB_DATABASE=app/' \
  -e 's/^# DB_USERNAME=.*/DB_USERNAME=app/' \
  -e 's/^# DB_PASSWORD=.*/DB_PASSWORD=app/' .env

# 4. Убедимся, что MySQL из brew не мешает
brew services stop mysql || true
pkill -f mysqld 2>/dev/null || true

# 5. Поднимаем окружение
docker compose -f docker-compose.dev.yml up -d --build

# 6. Устанавливаем зависимости и выполняем миграции
docker compose -f docker-compose.dev.yml exec php composer install --no-interaction
docker compose -f docker-compose.dev.yml exec php php artisan key:generate
docker compose -f docker-compose.dev.yml exec php php artisan storage:link || true
docker compose -f docker-compose.dev.yml exec php php artisan migrate --force

# 7. Устанавливаем composer локально (для IDE)
composer install

# 8. Устанавливаем JS-зависимости и запускаем Vite
npm ci
npm run dev
```

После этого приложение будет доступно:
- **http://localhost:8080** — backend (nginx → php)
- **http://localhost:5173** — фронтенд (Vite dev server)

---

## 🧩 Короткие команды

| Задача                                          | Команда |
|-------------------------------------------------|----------|
| Запустить окружение                             | `make up` |
| Остановить окружение                            | `make down` |
| Просмотреть логи                                | `make logs` |
| Выполнить миграции                              | `make migrate` |
| Очистить кеши Laravel                           | `make clear` |
| Пересобрать образы                              | `make rebuild` |
| После git pull (пересоберёт, запустит миграции) | `make post-pull` |
| Поднять фронтенд                                | `npm run dev` |
