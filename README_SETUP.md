# Developer Setup Guide

If you've just pulled this repository and find that styles or assets are missing, please follow these steps:

### 1. Install Dependencies
Ensure you have all PHP and Node dependencies:
```bash
composer install
npm install
```

```
*Note: Ensure `APP_URL` matches your local server address (e.g., `http://127.0.0.1:8000`).*

### 3. Asset Linking (CRITICAL)
Many images and certificates rely on the storage symbolic link. Run:
```bash
php artisan storage:link
```

### 4. Clear Cached Views
If changes aren't appearing, clear the Laravel view and config cache:
```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

### 5. Running the Asset Server (For Inertia/React Pages)
If you are visiting a page that uses Inertia/React (like the Login or Register pages), you MUST run the Vite development server:
```bash
npm run dev
```
For the **Admin Dashboard** and **Student Learning Workspace**, we use a build-free Tailwind CDN approach, so they should work without Vite as long as you have an active internet connection.
