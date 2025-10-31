#!/usr/bin/env sh
set -e

# Каталог под сокет может быть томом (root:root) — чиним права каждый старт
mkdir -p /var/run/php
chown -R www-data:www-data /var/run/php

# Ждем БД
if [ -n "${WAIT_FOR_DB_HOST}" ]; then
  for i in $(seq 1 60); do
    nc -z "${WAIT_FOR_DB_HOST}" "${WAIT_FOR_DB_PORT:-3306}" && break
    sleep 1
  done
fi

# Запускаем FPM от root
exec php-fpm -F
