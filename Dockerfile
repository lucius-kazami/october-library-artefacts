FROM php:7.4-cli

# 1. Устанавливаем системные пакеты и зависимости
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libzip-dev zip unzip git \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# 2. Устанавливаем Composer прямо в контейнер
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# 3. Копируем проект
COPY . /var/www/html
WORKDIR /var/www/html

# 4. Устанавливаем библиотеки (те самые vendor файлы)
# Флаг --ignore-platform-reqs поможет избежать конфликтов версий
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 5. Настройка прав
RUN chmod -R 775 storage themes plugins

# 6. Запуск
CMD php -S 0.0.0.0:$PORT index.php
