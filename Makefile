# === Конфигурация ===
DC := docker compose -f docker-compose.dev.yml

# === Основные команды ===

## Поднять окружение (php, nginx, mysql, redis)
up:
	$(DC) up -d

## Остановить контейнеры
down:
	$(DC) down

## Пересобрать образы (с нуля)
rebuild:
	$(DC) down -v
	$(DC) up -d --build

## Просмотреть логи (живой поток)
logs:
	$(DC) logs -f --tail=200

## Установить зависимости composer
composer-install:
	$(DC) exec php composer install --no-interaction

## Выполнить миграции
migrate:
	$(DC) exec php php artisan migrate --force

## Пересоздать базу (drop + migrate + seed)
fresh:
	$(DC) exec php php artisan migrate:fresh --seed --force

## Очистить кеши Laravel
clear:
	$(DC) exec php php artisan optimize:clear

## Открыть bash в php-контейнере
bash:
	$(DC) exec php bash

## Запустить vite в режиме разработки (локально)
dev:
	npm run dev

## Полная инициализация (после git pull)
post-pull:
	$(DC) down -v
	$(DC) up -d --build
	$(DC) exec php composer install --no-interaction
	$(DC) exec php php artisan key:generate
	$(DC) exec php php artisan storage:link || true
	$(DC) exec php php artisan migrate --force
	npm i
	npm run build
