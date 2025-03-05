# Utilisation d'une image PHP avec Apache
FROM php:8.2-apache

# Installation des extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev unzip git curl \
    && docker-php-ext-install pdo pdo_mysql zip \
    && a2enmod rewrite

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copie des fichiers Laravel dans le conteneur
WORKDIR /var/www/html
COPY . .

# Installation des dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Définition des permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port 80
EXPOSE 80

CMD ["apache2-foreground"]
