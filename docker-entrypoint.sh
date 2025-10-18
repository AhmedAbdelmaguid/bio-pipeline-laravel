#!/bin/sh
set -e

cd /app

run_artisan() {
  php -d variables_order=EGPCS artisan "$@"
}

ensure_env_file() {
  if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
  fi
}

write_app_key() {
  KEY_VALUE="$1"
  if [ -f .env ]; then
    awk -v key="${KEY_VALUE}" 'BEGIN{updated=0} /^APP_KEY=/{print "APP_KEY=" key; updated=1; next} {print} END{if(updated==0) print "APP_KEY=" key}' .env > .env.tmp \
      && mv .env.tmp .env
  else
    printf 'APP_KEY=%s\n' "${KEY_VALUE}" > .env
  fi
}

ensure_app_key() {
  if [ -n "${APP_KEY}" ]; then
    write_app_key "${APP_KEY}"
    return
  fi

  CURRENT_KEY=""
  if [ -f .env ]; then
    CURRENT_KEY=$(grep -E '^APP_KEY=' .env 2>/dev/null | head -n 1 | cut -d= -f2- | tr -d '\r')
  fi

  if [ -z "${CURRENT_KEY}" ]; then
    CURRENT_KEY=$(php -r "echo 'base64:'.base64_encode(random_bytes(32));")
    if [ -z "${CURRENT_KEY}" ]; then
      echo "Failed to generate APP_KEY" >&2
      exit 1
    fi
    write_app_key "${CURRENT_KEY}"
  fi

  export APP_KEY="${CURRENT_KEY}"
}

prepare_sqlite() {
  if [ "${DB_CONNECTION}" = "sqlite" ] || [ -z "${DB_CONNECTION}" ]; then
    DB_PATH="${DB_DATABASE:-/app/database/database.sqlite}"
    DB_DIR="$(dirname "${DB_PATH}")"
    [ -d "${DB_DIR}" ] || mkdir -p "${DB_DIR}"
    [ -f "${DB_PATH}" ] || touch "${DB_PATH}"
  fi
}

# Clear caches from previous runs (ignore failures if the key is missing yet)
run_artisan optimize:clear || true
rm -f bootstrap/cache/config.php || true

ensure_env_file
ensure_app_key
prepare_sqlite

# Run essential Artisan tasks, allowing the container to continue even if they fail
run_artisan migrate --force || true
run_artisan storage:link --force || true
run_artisan config:clear || true
run_artisan route:clear || true
run_artisan view:clear || true

exec "$@"
