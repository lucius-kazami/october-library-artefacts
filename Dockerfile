FROM php:7.4-apache

# 1. Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libzip-dev zip unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# 2. ЖЕСТКОЕ РЕШЕНИЕ ПРОБЛЕМЫ MPM:
# Удаляем все файлы конфигурации MPM, кроме prefork, чтобы у Apache не было выбора
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf \
    && a2enmod mpm_prefork

# 3. Включаем mod_rewrite
RUN a2enmod rewrite

# 4. Копируем файлы проекта
COPY . /var/www/html/

# 5. Настройка прав
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/themes /var/www/html/plugins \
    && chmod -R 775 /var/www/html/storage /var/www/html/themes /var/www/html/plugins

# Указываем порт (Railway сам прокинет 80-й порт наружу)
ENV PORT 80
EXPOSE 80

CMD ["apache2-foreground"]
