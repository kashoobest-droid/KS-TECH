# Deploying KS Tech Store to Railway

Your Laravel project is **ready to deploy** on [Railway](https://railway.com). Follow this guide.

---

## Prerequisites

- Code pushed to **GitHub** (or GitLab/Bitbucket)
- A [Railway](https://railway.com) account
- GitHub connected to Railway

---

## Step 1: Create a New Project on Railway

1. Go to [railway.com](https://railway.com) and sign in
2. Click **New Project**
3. Select **Deploy from GitHub repo**
4. Choose your `tech_store_app` repository

---

## Step 2: Add a Database

Railway will create your app. You need a database:

1. In your project, click **+ New**
2. Select **Database** → **Add MySQL** (or **PostgreSQL** if you prefer)
3. Railway will provision the database and create a `DATABASE_URL` variable

**If you use PostgreSQL** (Railway's default), add this to your project's **Variables**:
- `DB_CONNECTION=pgsql`

Laravel will read `DATABASE_URL` and configure the connection automatically.

---

## Step 3: Set Environment Variables

In your **Laravel service** → **Variables** tab, add:

| Variable | Value | Required |
|----------|-------|----------|
| `APP_KEY` | Run `php artisan key:generate --show` locally and paste the result | ✅ Yes |
| `APP_ENV` | `production` | ✅ Yes |
| `APP_DEBUG` | `false` | ✅ Yes |
| `APP_URL` | Your Railway URL, e.g. `https://your-app.up.railway.app` | ✅ Yes |
| `DB_CONNECTION` | `mysql` or `pgsql` (match your database) | ✅ Yes |

**Note:** Railway injects `DATABASE_URL` when you add a MySQL/PostgreSQL service. If it doesn't, you can set `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` manually.

Other optional variables (keep defaults if unsure):
- `CACHE_DRIVER=file`
- `SESSION_DRIVER=file`
- `FILESYSTEM_DISK=local`

---

## Step 4: Configure Root Directory (if needed)

If your Laravel app is in a subfolder, set **Root Directory** in Railway service settings to that folder (e.g. `/` if the repo root is the app).

---

## Step 5: Deploy

1. Railway will auto-deploy on every push to your main branch
2. Or click **Deploy** manually
3. Check the **Deployments** tab for build logs

---

## Important: File Uploads (Avatars & Product Images)

Railway uses an **ephemeral filesystem**. Uploaded files (avatars, product images) will be **lost on redeploy**.

### Option A: Use Railway Volumes (Recommended for simplicity)

1. In your project, click **+ New** → **Volume**
2. Create a volume and name it e.g. `uploads`
3. In your **Laravel service** settings, attach the volume
4. Set the **Mount Path** to: `/home/kashoo/Documents/IS/Ecommerce/project/tech_store_app/public/upload`

**Note:** The app root on Railway is typically the workspace root. Set the Volume mount path to: `public/upload` (relative) or the full path shown in Railway's volume settings.

This persists the `public/upload` directory across deploys.

### Option B: Use Cloud Storage (S3, etc.)

For production, consider storing uploads on S3, Cloudflare R2, or similar. This requires code changes to use Laravel's filesystem with an S3 driver.

---

## Step 6: Create an Admin User

After the first deploy:

1. Open Railway's **Shell** for your service (or use `railway run`)
2. Run: `php artisan tinker`
3. In tinker:
   ```php
   $u = App\Models\User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('your-password'),'is_admin'=>true]);
   ```
4. Or use a seeder if you have one

---

## Files Already Updated for Railway

These files were updated for deployment:

| File | Change |
|------|--------|
| `.nixpacks.toml` | PHP 8.3, Node.js, build steps, migration on start |
| `app/Http/Middleware/TrustProxies.php` | Trust all proxies (for Railway's load balancer) |

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Build fails on `composer install` | Ensure `APP_KEY` is set before first deploy |
| 500 error after deploy | Check logs in Railway dashboard; often `APP_KEY` or database config |
| Database connection failed | Verify `DATABASE_URL` or `DB_*` variables; check DB is running |
| Uploads disappear on redeploy | Add a Volume (see Option A above) or use S3 |
| Mixed content (HTTP/HTTPS) | Set `APP_URL` to `https://your-app.up.railway.app` |

---

## Useful Commands (Railway Shell)

```bash
php artisan migrate --force   # Run migrations
php artisan db:seed           # Run seeders
php artisan config:clear      # Clear config cache
php artisan cache:clear       # Clear application cache
```

---

## Custom Domain (Optional)

1. In your service → **Settings** → **Domains**
2. Add your custom domain
3. Update `APP_URL` to match
