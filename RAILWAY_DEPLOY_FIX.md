# Laravel Railway Deployment Fix

## Problems Identified

1. **APP_KEY Missing**: Railway doesn't have `APP_KEY` set in environment variables
2. **PHP Parse Error**: Syntax error in `bootstrap/app.php` line 21

## Solution Steps

### Step 1: Generate APP_KEY locally
Run this command in your terminal:
```bash
php artisan key:generate --show
```

This will output something like:
```
base64:dR9fsrTF4fSPOJCHhk/9BR6fxr+e2cTIqVsVkLDI+H0=
```

### Step 2: Add APP_KEY to Railway

1. Go to your Railway project dashboard
2. Click on your Laravel service
3. Go to **Variables** tab
4. Add a new variable:
   - **Name**: `APP_KEY`
   - **Value**: (paste the key from step 1)
5. Click **Add** or **Update**

### Step 3: Add other required environment variables

Make sure these are also set in Railway:

```
APP_NAME=Laravel
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sistem-managemen-ukm-production.up.railway.app

DB_CONNECTION=mysql
DB_HOST=(your-railway-mysql-host)
DB_PORT=3306
DB_DATABASE=(your-database-name)
DB_USERNAME=(your-database-user)
DB_PASSWORD=(your-database-password)
```

### Step 4: Fix bootstrap/app.php (if needed)

If you still get parse errors, check line 21 in `bootstrap/app.php`. The code should look like this:

```php
$exceptions->shouldRenderJsonWhen(
    fn (Request $request) => $request->is('api/*'),
);
```

### Step 5: Redeploy

1. Commit the `railway.json` file to git
2. Push to GitHub
3. Railway will automatically redeploy

## Alternative: Use railway.json Build Command

The `railway.json` file has been created with proper configuration. Make sure it's committed to your repository.

## Verify Deployment

After deployment, check:
1. Railway logs for any errors
2. Visit your app URL
3. Run `php artisan migrate --force` via Railway console if needed

## Common Issues

- **APP_KEY error**: Make sure APP_KEY is set in Railway Variables (not just in .env)
- **Database connection**: Ensure MySQL service is connected and environment variables are correct
- **Parse error**: Check for syntax errors in PHP files