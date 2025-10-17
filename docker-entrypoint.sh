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

  php artisan migrate --force || {
    echo "Failed to run migrations against ${DB_PATH}" >&2
    exit 1
  }
fi

exec "$@"
