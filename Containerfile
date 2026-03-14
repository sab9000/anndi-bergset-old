FROM docker.io/library/php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Imagick extension (used by imagestreamer)
RUN apt-get update \
    && apt-get install -y --no-install-recommends libmagickwand-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && rm -rf /var/lib/apt/lists/*

# Set document root to the OOP entry point
ENV APACHE_DOCUMENT_ROOT=/var/www/html/files/webroot/www

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess overrides and add alias for backend (outside document root)
RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf \
    && echo 'Alias "/backend" "/var/www/html/backend"\n<Directory "/var/www/html/backend">\n    Require all granted\n</Directory>' \
       > /etc/apache2/conf-available/backend-alias.conf \
    && a2enconf backend-alias

# Copy application files
COPY . /var/www/html/

EXPOSE 80
