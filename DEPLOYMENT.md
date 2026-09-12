# Deploying to Hostinger (mir.codes)

One-time setup, then a repeatable deploy flow via git + SSH.

## 1. hPanel one-time setup

1. **SSH access** — hPanel → Advanced → SSH Access → enable it, note the host/port/username.
2. **MySQL database** — hPanel → Databases → MySQL Databases → create a database + user, grant
   all privileges. Save the DB name/user/password for `.env`.
3. **Email mailbox** — hPanel → Emails → create `contact@mir.codes` (contact-form notifications
   are sent to this address, via `SiteSettings->contact_email` in `/admin`). Save its password
   for `MAIL_PASSWORD`.
4. **PHP version** — hPanel → Advanced → PHP Configuration → set PHP 8.2 or newer.
5. **Git deployment** — hPanel → Advanced → Git → connect this repository and branch (`main`),
   targeting a directory *outside* the web root, e.g. `/home/<user>/mir-app`. Add `deploy.sh`
   (already in this repo) as the post-pull deployment script if hPanel offers that field.
6. **Point the domain at `/public`**:
   - If your plan lets you set a custom document root (Websites → mir.codes → Advanced), point
     it at `/home/<user>/mir-app/public`. This is the clean option — do this if it's available.
   - If it doesn't, use the passthrough fallback: copy everything from `mir-app/public/` into
     `public_html/`, then edit `public_html/index.php` so its two `require` lines point up a
     level, e.g. `require __DIR__.'/../mir-app/vendor/autoload.php';` and
     `require_once __DIR__.'/../mir-app/bootstrap/app.php';`. Re-run this copy step after every
     deploy that changes `public/` (new build hashes, etc.) — a small script or symlinking the
     individual files avoids repeating it by hand.

## 2. First deploy

```bash
ssh <user>@<host>
cd ~/mir-app          # wherever the Git deploy tool checked the repo out
cp .env.production.example .env
nano .env              # fill in APP_KEY (leave blank for now), DB_*, MAIL_*
php artisan key:generate
bash deploy.sh          # composer install, npm build (if node is present), migrate, cache
php artisan db:seed --class=AdminUserSeeder   # creates the /admin login
```

If `deploy.sh`'s `npm run build` step is skipped (no Node on the server), build assets on your
machine first and commit/upload the resulting `public/build/` directory.

Set permissions so PHP can write logs/cache/uploads:

```bash
chmod -R 775 storage bootstrap/cache
```

## 3. Cron (for the daily sitemap regeneration)

hPanel → Advanced → Cron Jobs → add, every minute:

```
* * * * * cd /home/<user>/mir-app && php artisan schedule:run >> /dev/null 2>&1
```

This drives `Schedule::command('sitemap:generate')->daily()` in `routes/console.php`. No queue
worker/daemon is needed — `.env.production.example` sets `QUEUE_CONNECTION=sync`, so contact-form
emails send inline instead of needing `queue:work` kept running.

## 4. Verify

- `https://mir.codes` loads over HTTPS, `http://` and `www.` both redirect to it
  (`public/.htaccess`).
- `/admin` login works with the seeded admin user.
- Submit the contact form and confirm the notification email arrives.
- Uploaded project screenshots render (`php artisan storage:link` must have run —
  `deploy.sh` does this).
- `php artisan test` passes locally before you push.

## 5. Repeat deploys

```bash
git push origin main            # triggers hPanel's Git auto-pull, or pull manually over SSH
ssh <user>@<host> "cd ~/mir-app && bash deploy.sh"
```
