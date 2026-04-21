FROM php:8.2-apache

# Cài extension cần thiết
RUN docker-php-ext-install pdo pdo_mysql

# Copy source
COPY . /var/www/html/

# Set thư mục public làm root
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Enable rewrite
RUN a2enmod rewrite

# Quyền
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80