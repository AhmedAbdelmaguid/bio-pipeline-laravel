# Usa un'immagine PHP con estensioni Laravel
FROM php:8.2-cli

# Installa dipendenze di sistema e Node.js
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    sqlite3 libsqlite3-dev nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite zip gd mbstring

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Imposta la directory di lavoro
WORKDIR /app

# Copia i file del progetto
COPY . .

# Installa le dipendenze di Laravel e compila gli asset
# Crea un file .env di base se assente per consentire alle installazioni di completarsi
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && composer install \
    && npm install \
    && npm run build

# Copia lo script di avvio che prepara il database
COPY docker-entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Espone la porta usata da Laravel
EXPOSE 8000

# Comando per avviare Laravel
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
