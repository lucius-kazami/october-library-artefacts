FROM php:7.4-apache

# 1. Устанавливаем системные зависимости для Postgres и PHP расширений
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# 2. Исправляем ошибку "More than one MPM loaded"
# Отключаем лишние модули и принудительно включаем prefork (нужен для PHP)
RUN a2dismod mpm_event && a2enmod mpm_prefork

# 3. Включаем mod_rewrite для работы роутов OctoberCMS
RUN a2enmod rewrite

# 4. Копируем файлы проекта
COPY . /var/www/html/

# 5. Настройка прав для папок OctoberCMS
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/themes /var/www/html/plugins
RUN chmod -R 775 /var/www/html/storage /var/www/html/themes /var/www/html/plugins

# Указываем порт
ENV PORT 80
EXPOSE 80

CMD ["apache2-foreground"]
