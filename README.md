# Bio Pipeline Laravel

Web app Laravel per la progettazione visuale di pipeline bioinformatiche con editor drag-and-drop e salvataggio JSON.

## Funzionalità
- Auth con Laravel Breeze, dashboard progetti e profilo utente.
- Editor visuale (Blade + Alpine.js) con moduli/blocchi, link, warning qualità, autosave e import/export JSON.
- API REST per salvare la pipeline in `projects.metadata` (JSON).
- Build frontend con Vite; DB MySQL/MariaDB/SQLite.

## Stack
- Backend: PHP 8.2+, Laravel 12, Breeze per auth, Policy per ownership progetti.
- Frontend: Blade + Alpine.js, CSS personalizzato, canvas per collegamenti, Vite.

## Setup rapido
```bash
git clone https://github.com/AhmedAbdelmaguid/bio-pipeline-laravel.git
cd bio-pipeline-laravel

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate

php artisan serve
npm run dev
```

## Deploy rapido su Fly.io (demo con SQLite)
- Installa `flyctl` e fai login: `flyctl auth login`.
- Crea volume per il DB: `flyctl volumes create data --size 1 --region <regione>`.
- Configura `fly.toml` (già incluso) con `DB_CONNECTION=sqlite` e mount `/app/database`.
- Imposta i secrets (almeno `APP_KEY`): `flyctl secrets set APP_KEY=$(php -r "echo base64_encode(random_bytes(32));")`.
- Deploy: `flyctl deploy`.
- Esegui migrazioni nel container: `flyctl ssh console` → `php artisan migrate --force`.

## Note su pipeline
- I workflow sono serializzati in `projects.metadata` (moduli, blocchi, link, parametri, foreach).
- Avvisi automatici su blocchi non collegati o parametri mancanti; auto-allineamento layout.
- Import/export JSON dal canvas per condividere o versionare la pipeline.
