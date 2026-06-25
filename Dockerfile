FROM php:8.2-apache

# Enable Apache mod_rewrite (needed for Kirby's routing)
RUN a2enmod rewrite

# Install system dependencies required by the GD extension
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Install the GD PHP extension with JPEG and FreeType support
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Copy your project files into the container
COPY . /var/www/html/

# Set correct file permissions for Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Allow .htaccess overrides (required for Kirby)
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

EXPOSE 80