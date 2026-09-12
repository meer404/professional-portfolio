#!/bin/bash
# Run on the Hostinger server after a git pull (wire this in as the hPanel
# Git "deployment script", or run it by hand over SSH).
set -euo pipefail

composer install --no-dev --optimize-autoloader

# Skip if Node isn't available on this plan — build assets locally instead
# and commit/upload public/build.
if command -v npm >/dev/null 2>&1; then
    npm ci
    npm run build
fi

php artisan migrate --force
php artisan storage:link || true

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
