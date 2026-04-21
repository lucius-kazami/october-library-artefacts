FROM php:7.4-cli

# 1. Устанавливаем только нужные системные пакеты
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libzip-dev zip unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# 2. Копируем проект
COPY . /var/www/html
WORKDIR /var/www/html

# 3. Настройка прав
RUN chmod -R 775 storage themes plugins

# 4. Запускаем встроенный сервер PHP напрямую
# Мы используем 0.0.0.0, чтобы Railway мог "увидеть" контейнер снаружи
CMD php -S 0.0.0.0:$PORT index.php
