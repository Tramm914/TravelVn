# Sử dụng môi trường PHP 8.2 kèm Apache
FROM php:8.2-apache

# Cài đặt extension MySQL cho PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Bật mod_rewrite (Bắt buộc cho MVC để chạy route/webhook)
RUN a2enmod rewrite

# Cấu hình Apache trỏ thẳng vào thư mục public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy toàn bộ code vào server
COPY . /var/www/html/

# Cấp quyền
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

EXPOSE 80