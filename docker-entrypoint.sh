#!/bin/sh
set -e

cd /app

# 0) Pulisci eventuali cache “sporche” PRIMA di tutto
php -d variables_order=EGPCS artisan optimize:clear || true
rm -f bootstrap/cache/config.php || true

# 1) Crea .env se manca
if [ ! -f .env ] && [ -f .env.example ]; then
  cp .env.example .env
fi

# 2) APP_KEY:
#    - se arriva da ENV, forzala dentro .env (così anche con config:cache Laravel la vede)
#    - altrimenti, se manca pure in .env, generala
if [ -n "$APP_KEY" ]; then
  # sovrascrivi/aggiungi la riga APP_KEY=
  if grep -q '^APP_KEY=' .env; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY//\\/\\\\}|" .env
  else
    printf "\nAPP_KEY=%s\n" "$APP_KEY" >> .env
  fi
else
  if ! grep -Eq '^APP_KEY=.+$' .env; then
    php -d variables_order=EGPCS artisan key:generate --force
  fi
  # Esporta APP_KEY dall'.env per sicurezza
  KEY_LINE=$(grep -E '^APP_KEY=' .env | head -n1 || true)
  KEY_VALUE=$(printf '%s' "${KEY_LINE#APP_KEY=}" | tr -d '\r')
  if [ -n "$KEY_VALUE" ]; then export APP_KEY="$KEY_VALUE"; fi
fi

# 3) Prepara SQLite se serve
if [ "${DB_CONNECTION}" = "sqlite" ] || [ -z "${DB_CONNECTION}" ]; then
  DB_PATH="${DB_DATABASE:-/app/database/database.sqlite}"
  DB_DIR="$(dirname "${DB_PATH}")"
  [ -d "$DB_DIR" ] || mkdir -p "$DB_DIR"
  [ -f "$DB_PATH" ] || touch "$DB_PATH"
fi

# 4) Migrazioni, symlink storage, pulizia/ottimizzazione finale
php -d variables_order=EGPCS artisan migrate --force || true
php -d variables_order=EGPCS artisan storage:link --force || true
php -d variables_order=EGPCS artisan config:clear || true
php -d variables_order=EGPCS artisan route:clear || true
php -d variables_order=EGPCS artisan view:clear || true

exec "$@"
