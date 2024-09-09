# Use the official PHP image as the base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    autoconf \
    zlib1g-dev \
    libicu-dev \
    pkg-config \
    libc-ares-dev \
    libprotobuf-dev \
    protobuf-compiler \
    protobuf-c-compiler \
    libprotoc-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip -j$(nproc)

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install gRPC and protobuf PHP extensions
RUN pecl install grpc protobuf \
    && docker-php-ext-enable grpc protobuf

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www

# Change current user to www
USER www-data
