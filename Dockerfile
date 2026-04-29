FROM php:8.2-apache

# 1. ĐÃ THÊM BCMATH VÀO ĐÂY
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install zip pdo pdo_mysql bcmath

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy source code
COPY . /var/www/html/

# Chạy Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# Config Apache (đã làm ở bước trước)
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Phân quyền
RUN chown -R www-data:www-data /var/www/html