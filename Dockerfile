# PHP con estensioni necessarie
FROM php:8.2-cli

# Dipendenze di sistema + Node
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    sqlite3 libsqlite3-dev nodejs npm \
 && docker-php-ext-install pdo pdo_sqlite zip gd mbstring

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Installa dipendenze e build asset (senza .env)
RUN composer install --no-interaction --prefer-dist --no-dev \
 && npm install \
 && npm run build

# Entrypoint
COPY docker-entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["sh","-lc","php -d variables_order=EGPCS artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
