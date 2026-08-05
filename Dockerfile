FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Set up SSH directory for Git deploy key
RUN mkdir -p /var/www/.ssh && \
    chmod 700 /var/www/.ssh && \
    ssh-keyscan github.com >> /var/www/.ssh/known_hosts && \
    chown -R www-data:www-data /var/www/.ssh

# Copy project files
COPY . /var/www/html/

# Install PHP dependencies (this pulls in the kirby/ folder)
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && mkdir -p /var/www/html/site/accounts \
    && mkdir -p /var/www/html/site/sessions \
    && chmod -R 775 /var/www/html/site/accounts \
    && chmod -R 775 /var/www/html/site/sessions \
    && chmod -R 775 /var/www/html/content

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Git identity for content commits
RUN git config --global user.email "johannes@schmoll.studio" && \
    git config --global user.name "joh-sch" && \
    git config --global --add safe.directory /var/www/html

# Entrypoint script (writes deploy key at runtime)
COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
