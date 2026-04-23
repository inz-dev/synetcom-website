FROM php:8.2-apache

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev zip nodejs npm

# Extensions PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Activer Apache rewrite
RUN a2enmod rewrite

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier projet
WORKDIR /var/www/html
COPY . .

# Installer Laravel
RUN composer install --no-dev --optimize-autoloader

# Build Vue (Vite)
RUN npm install && npm run build

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Config Apache vers /public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Port Render
ENV PORT=10000
EXPOSE 10000

CMD ["apache2-foreground"]
