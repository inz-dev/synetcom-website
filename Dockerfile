FROM php:8.3-apache

# Dépendances système + libpq pour PostgreSQL
RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libpng-dev libonig-dev libxml2-dev libpq-dev \
    nodejs npm \
    && rm -rf /var/lib/apt/lists/*

# Extensions PHP (pdo_pgsql au lieu de pdo_mysql)
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Apache : activer rewrite + .htaccess
RUN a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Dépendances PHP (sans dev) + assets Vue/Vite
RUN composer install --no-dev --optimize-autoloader
RUN npm ci && npm run build && rm -rf node_modules

# Permissions storage & cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Configurer Apache :
#   - document root → /public
#   - AllowOverride All pour .htaccess Laravel
#   - port → 10000 (Render)
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<VirtualHost \*:80>/a\\t<Directory /var/www/html/public>\n\t\tAllowOverride All\n\t\tRequire all granted\n\t</Directory>' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' /etc/apache2/sites-available/000-default.conf

ENV PORT=10000
EXPOSE 10000

# Au démarrage : cache config, migrations, cache routes/vues, puis lance Apache
CMD ["/bin/bash", "-c", \
    "php artisan config:cache && \
     php artisan migrate --force && \
     php artisan route:cache && \
     php artisan view:cache && \
     apache2-foreground"]
