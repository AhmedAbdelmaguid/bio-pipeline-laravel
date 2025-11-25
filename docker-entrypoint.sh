#!/bin/sh
set -e

cd /app

# Rimuovi eventuale config cache "sporca"
rm -f bootstrap/cache/config.php || true

# Crea .env se manca
if [ ! -f .env ] && [ -f .env.example ]; then
  cp .env.example .env
fi

# APP_KEY: se arriva da ENV, scrivila dentro .env (portabile senza bash)
if [ -n "$APP_KEY" ]; then
  awk -v v="$APP_KEY" '
    BEGIN{done=0}
    /^APP_KEY=/{print "APP_KEY=" v; done=1; next}
    {print}
    END{if(!done) print "APP_KEY=" v}
  ' .env > .env.new && mv .env.new .env
else
  if ! grep -Eq '^APP_KEY=.+$' .env 2>/dev/null; then
    php -d variables_order=EGPCS artisan key:generate --force
  fi
  KEY_LINE=$(grep -E '^APP_KEY=' .env 2>/dev/null | head -n1 || true)
  KEY_VALUE=$(printf '%s' "${KEY_LINE#APP_KEY=}" | tr -d '\r')
  if [ -n "$KEY_VALUE" ]; then export APP_KEY="$KEY_VALUE"; fi
fi

# Prepara percorsi storage/cache prima di tutto
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/testing \
         storage/framework/views \
         storage/logs \
         bootstrap/cache

# Prepara SQLite PRIMA di toccare la cache
if [ "${DB_CONNECTION}" = "sqlite" ] || [ -z "${DB_CONNECTION}" ]; then
  DB_PATH="${DB_DATABASE:-/app/storage/db/database.sqlite}"
  DB_DIR="$(dirname "${DB_PATH}")"
  [ -d "$DB_DIR" ] || mkdir -p "$DB_DIR"
  [ -f "$DB_PATH" ] || : > "$DB_PATH"
fi

# Permessi per storage/cache e db
chmod -R ug+rwX storage bootstrap/cache || true
[ -n "$DB_PATH" ] && [ -f "$DB_PATH" ] && chmod 664 "$DB_PATH" || true

# Pulisci cache forzando driver file (evita DB durante i clear)
export CACHE_DRIVER=${CACHE_DRIVER:-file}
php -d variables_order=EGPCS artisan config:clear || true
php -d variables_order=EGPCS artisan route:clear  || true
php -d variables_order=EGPCS artisan view:clear   || true
php -d variables_order=EGPCS artisan cache:clear  || true

# Migrazioni e symlink storage (fallire deve mostrare l'errore)
php -d variables_order=EGPCS artisan migrate --force
php -d variables_order=EGPCS artisan storage:link --force

exec "$@"
