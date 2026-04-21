FROM php:7.4-cli

# 1. Устанавливаем зависимости, необходимые для Composer и Postgres
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libzip-dev zip unzip git \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# 2. Устанавливаем Composer (официальный образ)
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# 3. Копируем проект в папку сервера
COPY . /var/www/html
WORKDIR /var/www/html

# 4. УСТАНАВЛИВАЕМ БИБЛИОТЕКИ (те самые vendor файлы)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# 5. Настройка прав (OctoberCMS это критично)
RUN chmod -R 775 storage themes plugins

# 6. Запуск сервера
CMD php -S 0.0.0.0:$PORT index.php
