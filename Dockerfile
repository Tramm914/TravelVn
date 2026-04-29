# (Có thể bạn đã có dòng này)
FROM php:8.2-apache

# Cài đặt extension zip (rất quan trọng để Composer giải nén thư viện)
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql

# 1. CÀI ĐẶT COMPOSER (Thêm dòng này nếu chưa có)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 2. COPY MÃ NGUỒN VÀO THƯ MỤC CỦA DOCKER
COPY . /var/www/html/

# 3. CHẠY LỆNH CÀI ĐẶT THƯ VIỆN (Thêm dòng này)
# Thêm quyền để composer chạy dưới quyền root không bị cảnh báo
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# Cấp quyền cho thư mục (để tránh lỗi permission denied)
RUN chown -R www-data:www-data /var/www/html