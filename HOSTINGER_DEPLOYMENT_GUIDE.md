# Hostinger Deployment Guide for Matnog Tourism

## Issues Fixed
1. ✅ Fixed middleware alias from 'rolemiddleware' to 'role' in Kernel.php
2. ✅ Created proper .htaccess file for Apache server
3. ✅ Identified missing .env configuration

## Steps to Deploy on Hostinger

### 1. Create .env File on Hostinger
Since the .env file is blocked locally, you need to create it directly on Hostinger:

1. Log into your Hostinger control panel
2. Go to File Manager
3. Navigate to your domain's public_html folder
4. Create a new file called `.env`
5. Add the following content (replace with your actual values):

```env
APP_NAME="Matnog Tourism"
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://matnogsubictourism.site

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# SMS Configuration (Semaphore)
SEMAPHORE_API_KEY=your_semaphore_api_key
SEMAPHORE_SENDER_NAME=MATNOG
```

### 2. Generate Application Key
Run this command in your Hostinger terminal or via SSH:
```bash
php artisan key:generate
```

### 3. Database Setup
1. Create a MySQL database in your Hostinger control panel
2. Update the database credentials in your .env file:
   - DB_DATABASE: your database name
   - DB_USERNAME: your database username  
   - DB_PASSWORD: your database password

### 4. Run Migrations
```bash
php artisan migrate
```

### 5. Clear and Cache Configuration
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Set Proper File Permissions
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 7. Upload Files to Hostinger
Upload all your project files to the public_html directory, making sure:
- The `public` folder contents are in the root of public_html
- All other Laravel files are in the parent directory of public_html

### 8. Update Document Root (if needed)
If your Laravel app is in a subdirectory, update your .htaccess in the root:
```apache
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ /public/$1 [L,QSA]
```

## Common Issues and Solutions

### HTTP 500 Error
- Check if .env file exists and has correct permissions
- Verify database credentials
- Check Laravel logs in storage/logs/laravel.log
- Ensure all required PHP extensions are installed

### Database Connection Issues
- Verify database credentials in .env
- Check if database exists and user has proper permissions
- Ensure MySQL service is running

### File Permission Issues
- Set proper permissions: chmod -R 755 storage bootstrap/cache
- Ensure web server can write to storage and cache directories

## Required PHP Extensions
Make sure these are enabled on Hostinger:
- PHP 8.1 or higher
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML

## Testing Your Deployment
1. Visit https://matnogsubictourism.site
2. Check if the homepage loads without errors
3. Test user registration/login functionality
4. Verify database operations work correctly

## Support
If you continue to experience issues:
1. Check the Laravel logs in storage/logs/laravel.log
2. Enable APP_DEBUG=true temporarily to see detailed error messages
3. Contact Hostinger support for server-specific issues
