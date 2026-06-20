FROM php:8.3-apache

# Install dependency system
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    intl \
    zip \
    mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache Rewrite
RUN a2enmod rewrite

# Ubah DocumentRoot ke folder public CI4
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy source code
COPY . /var/www/html

# Install dependency CI4
RUN composer install --no-dev --optimize-autoloader || true

# Permission writable
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

EXPOSE 80