#!/usr/bin/env bash
# Skrip deploy/update untuk Hostinger Cloud (dijalankan via SSH di folder project).
# Pemakaian: bash deploy.sh
set -euo pipefail

COMPOSER_BIN="${COMPOSER_BIN:-composer2}"
command -v "$COMPOSER_BIN" >/dev/null 2>&1 || COMPOSER_BIN=composer

echo "→ PHP: $(php -r 'echo PHP_VERSION;') (wajib 8.3+)"
php -r 'exit(version_compare(PHP_VERSION, "8.3.0", ">=") ? 0 : 1);' || { echo "PHP CLI < 8.3. Ubah versi PHP di hPanel."; exit 1; }

php artisan down --retry=15 || true

echo "→ Install dependency PHP"
"$COMPOSER_BIN" install --no-dev --optimize-autoloader --no-interaction

echo "→ Migrasi database"
php artisan migrate --force

[ -L public/storage ] || php artisan storage:link

echo "→ Cache konfigurasi, route, view, dan komponen Filament"
php artisan optimize:clear
php artisan optimize
php artisan filament:optimize

php artisan up
echo "✓ Deploy selesai"
