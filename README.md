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

## Note su pipeline
- I workflow sono serializzati in `projects.metadata` (moduli, blocchi, link, parametri, foreach).
- Avvisi automatici su blocchi non collegati o parametri mancanti; auto-allineamento layout.
- Import/export JSON dal canvas per condividere o versionare la pipeline.
