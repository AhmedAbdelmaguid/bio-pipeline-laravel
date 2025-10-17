#!/bin/sh
set -e

# Ensure an .env file exists in case the repository did not ship one
if [ ! -f /app/.env ] && [ -f /app/.env.example ]; then
  cp /app/.env.example /app/.env
fi

# Prepare SQLite database file when using the sqlite driver
if [ "${DB_CONNECTION}" = "sqlite" ] || [ -z "${DB_CONNECTION}" ]; then
  DB_PATH="${DB_DATABASE:-/app/database/database.sqlite}"
  DB_DIR="$(dirname "${DB_PATH}")"

  if [ ! -d "${DB_DIR}" ]; then
    mkdir -p "${DB_DIR}"
  fi

  if [ ! -f "${DB_PATH}" ]; then
    touch "${DB_PATH}"
  fi
fi

# Generate the application key if not provided via environment/.env
if [ -z "${APP_KEY}" ]; then
  if ! grep -Eq '^APP_KEY=.+$' /app/.env 2>/dev/null; then
    php artisan key:generate --force
  fi
fi

# Run migrations, refresh storage symlink, and clear caches
php artisan migrate --force
php artisan storage:link --force
php artisan optimize:clear

exec "$@"
