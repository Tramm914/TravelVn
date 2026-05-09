FROM php:8.2-apache

# Thiết lập thư mục làm việc mặc định để code gọn gàng hơn
WORKDIR /var/www/html

# 1. Cài đặt các extension (Ít thay đổi -> Đặt lên đầu để tận dụng Cache)
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install zip pdo pdo_mysql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/* 

# 2. Config Apache (Không phụ thuộc vào code -> Đặt lên trước code để Cache)
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. TỐI ƯU CACHE COMPOSER (Bước quan trọng nhất)
# Chỉ copy 2 file quản lý thư viện vào trước (Thêm dấu * đề phòng lúc đầu chưa có file lock)
COPY composer.json composer.lock* ./

# Cài đặt thư viện. Thêm cờ --no-scripts và --no-autoloader vì lúc này chưa có source code
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --no-scripts --no-autoloader

# 5. COPY SOURCE CODE
# Từ giờ trở đi, khi bạn sửa code, Render chỉ chạy lại TỪ BƯỚC NÀY
COPY . .

# Sau khi đã có toàn bộ code, mới map các class lại với nhau
RUN composer dump-autoload --optimize

# 6. Phân quyền
RUN chown -R www-data:www-data /var/www/html