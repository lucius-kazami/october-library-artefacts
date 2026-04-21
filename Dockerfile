FROM php:7.4-apache

# Устанавливаем зависимости для Postgres и расширения PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# Включаем mod_rewrite для работы роутов OctoberCMS
RUN a2enmod rewrite

# Копируем файлы проекта
COPY . /var/www/html/

# Настройка прав для OctoberCMS
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/themes /var/www/html/plugins

# Указываем порт для Railway
ENV PORT 80
EXPOSE 80

# Запуск через Apache (он сам подхватит index.php)
CMD ["apache2-foreground"]
