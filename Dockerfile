FROM php:7.4-cli

# 1. Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libzip-dev zip unzip git \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# 2. Устанавливаем Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# 3. Копируем проект
COPY . /var/www/html
WORKDIR /var/www/html

# 4. Устанавливаем библиотеки без скриптов
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# 5. Права доступа
RUN chmod -R 775 storage themes plugins

# 6. МАГИЧЕСКАЯ СТРОКА: сначала миграция, потом запуск сервера
CMD php artisan october:up --force && php -S 0.0.0.0:$PORT index.php
