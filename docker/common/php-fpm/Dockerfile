FROM php:8.2-fpm-alpine

# пакеты/расширения
RUN apk add --no-cache git zip unzip icu-dev oniguruma-dev libzip-dev bash shadow netcat-openbsd \
 && docker-php-ext-configure intl \
 && docker-php-ext-install -j"$(nproc)" pdo_mysql intl bcmath opcache

# === phpredis (Valkey/Redis) ===
# Нужны build-зависимости для pecl (их уже включает $PHPIZE_DEPS)
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
 && pecl install redis \
 && docker-php-ext-enable redis \
 && apk del .build-deps

# (Опционально) CLI для быстрой диагностики: ping, keys, get/set
# Это именно redis-cli, но протокол совместим — работает с Valkey без проблем
RUN apk add --no-cache redis

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Пул c сокетом
RUN mkdir -p /var/run/php
COPY docker/common/php-fpm/pool.d/www.conf /usr/local/etc/php-fpm.d/www.conf

# Entrypoint: чиним права тома под сокет и стартуем FPM
COPY docker/common/php-fpm/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]
