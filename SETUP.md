# EduLMS — Setup & Deployment Guide (WAMP)

> This document explains everything built so far, what you need on your other device (WAMP), and the exact steps to get it running.

---

## 📦 What We Built

A full **Learning Management System (LMS)** built with:

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 |
| Frontend | React 18 + Inertia.js |
| Styling | Bootstrap 5 + Bootstrap Icons (via CDN) + Inter font |
| Database | MySQL |
| Live Classes | Zoom API (stub — keys needed) |
| Payments | PhonePe PG (stub — keys needed) |
| Video Lessons | YouTube Embed |
| Auth | Username & Password (Laravel Breeze) |

### Pages Built

| Page | URL | Description |
|------|-----|-------------|
| Login | `/login` | Split blue/white panel login |
| Register | `/register` | Student registration |
| Dashboard | `/dashboard` | Stats, enrolled courses, upcoming classes |
| Courses | `/courses` | Course listing with search & filter |
| Course Detail | `/courses/{id}` | YouTube player, curriculum, materials tabs |
| Admission Form | `/admissions/create` | Apply for a course |
| My Admissions | `/admissions` | View application status |
| Live Classes | `/live-classes` | Zoom class join + upcoming schedule |
| Study Materials | `/materials` | Download PDFs and documents |
| Fee Management | `/fees` | Fee summary + pay now |
| Profile | `/profile` | Edit profile (Breeze default) |

### Database Tables

| Table | Purpose |
|-------|---------|
| `users` | Student/admin accounts |
| `courses` | Course catalog (title, price, instructor) |
| `batches` | Course batches (start/end dates, status) |
| `lessons` | Video lessons linked to courses (YouTube URLs) |
| `admissions` | Student applications to courses |
| `enrollments` | Active enrollments |
| `payments` | Payment records (PhonePe integration) |
| `fees` | Fee tracking per student |

---

## 🖥️ Requirements on the New Device (WAMP)

Make sure you have the following installed:

- **WAMP Server** (with Apache + MySQL + PHP 8.2+)
- **PHP 8.2 or higher** (check in WAMP tray → PHP version)
- **Composer** (https://getcomposer.org/download/)
- **Node.js 18+** and **npm** (https://nodejs.org/)
- **Git** (https://git-scm.com/)
- A browser (Chrome recommended)

### Verify before starting
Open CMD and run:
```cmd
php -v
composer -V
node -v
npm -v
git --version
```
All must return version numbers. If any say "not found", install them first.

---

## 🚀 Step-by-Step Setup

### Step 1 — Clone the Project

```bash
cd C:\wamp64\www
git clone https://github.com/nerajlal/LMS.git
cd LMS
```

### Step 2 — Install PHP Dependencies

```bash
composer install
```

> This installs Laravel and all backend packages from `composer.json`. Takes 1–3 minutes.

### Step 3 — Install Frontend Dependencies

```bash
npm install
```

> This installs React, Inertia.js, Vite, and all frontend packages. Takes 2–5 minutes.

### Step 4 — Set Up Environment File

```bash
copy .env.example .env
php artisan key:generate
```

Now open `.env` in a text editor and update these lines:

```env
APP_NAME="EduLMS"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_db
DB_USERNAME=root
DB_PASSWORD=
```

> **WAMP default**: username is `root`, password is empty. If you set a WAMP MySQL password, enter it here.

### Step 5 — Create the Database

1. Open your browser → go to `http://localhost/phpmyadmin`
2. Click **New** on the left sidebar
3. Enter database name: `lms_db`
4. Click **Create**

OR run this SQL in phpMyAdmin Query tab:
```sql
CREATE DATABASE IF NOT EXISTS lms_db;
```

### Step 6 — Run Database Migrations

```bash
php artisan migrate
```

> This creates all 8 tables in `lms_db`. You should see "Migration successful" for each table.

### Step 7 — Build Frontend Assets

```bash
npm run build
```

> This compiles all React components into the `public/build/` folder.

### Step 8 — Start the Laravel Server

```bash
php artisan serve
```

Open your browser and go to: **http://localhost:8000**

You should see the EduLMS login page! ✅

---

## 🔄 For Development (Hot Reload)

Run **two** terminal windows simultaneously:

**Terminal 1:**
```bash
php artisan serve
```

**Terminal 2:**
```bash
npm run dev
```

This gives you hot module reloading — changes to React files refresh instantly.

---

## 👤 Creating Your First Admin User

After migrations, register a user via the web UI at `/register`, or seed one via Tinker:

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@edulms.com',
    'password' => bcrypt('password123'),
    'email_verified_at' => now(),
]);
```

---

## ⚙️ Pending Integrations (Keys Required)

### PhonePe Payment Gateway
Add these to your `.env`:
```env
PHONEPE_MERCHANT_ID=your_merchant_id
PHONEPE_SALT_KEY=your_salt_key
PHONEPE_SALT_INDEX=1
PHONEPE_ENV=sandbox
```
Then implement `PaymentController@store` with the PhonePe SDK.

### Zoom Live Classes
Add to `.env`:
```env
ZOOM_API_KEY=your_api_key
ZOOM_API_SECRET=your_api_secret
```
Then implement meeting creation in `LiveClassController`.

---

## 📁 Project File Structure (Key Files)

```
LMS/
├── app/
│   ├── Http/Controllers/
│   │   ├── CourseController.php       ← Courses listing & detail
│   │   ├── AdmissionController.php    ← Admission form & status
│   │   ├── PaymentController.php      ← PhonePe stub
│   │   └── FeeController.php          ← Fee management
│   └── Models/
│       ├── Course.php, Batch.php, Lesson.php
│       ├── Admission.php, Enrollment.php
│       ├── Payment.php, Fee.php
├── database/migrations/               ← All 8 table schemas
├── resources/
│   ├── js/
│   │   ├── Layouts/LmsLayout.jsx      ← Main sidebar + topbar layout
│   │   └── Pages/
│   │       ├── Dashboard.jsx
│   │       ├── Auth/Login.jsx
│   │       ├── Courses/Index.jsx + Show.jsx
│   │       ├── Admissions/Create.jsx + Index.jsx
│   │       ├── LiveClasses/Index.jsx
│   │       ├── Materials/Index.jsx
│   │       └── Fees/Index.jsx
│   └── views/app.blade.php            ← Main HTML shell (CDN links here)
└── routes/web.php                     ← All URL routes
```

---

## 🎨 Theme

The theme matches **Courseplus** (https://demo.foxthemes.net/courseplus/):

| Element | Color |
|---------|-------|
| Body background | `#f3f4f6` (gray-50) |
| Sidebar background | `#ffffff` |
| Sidebar border | `#e5e7eb` |
| Top header | `linear-gradient(→, #3b82f6, #2563eb)` |
| Primary button / accent | `#2563eb` (blue-600) |
| Heading text | `#1f2937` |
| Body / muted text | `#6b7280` |
| Card background | `#ffffff` |
| Card shadow | `0 1px 3px rgba(0,0,0,0.08)` |
| Green (completed) | `#10b981` |
| Amber (live class) | `#f59e0b` |
| Pink (fees) | `#ec4899` |
| Red (live badge) | `#ef4444` |

---

## ❓ Troubleshooting

| Problem | Fix |
|---------|-----|
| `php not found` | Add PHP to Windows PATH, or open CMD from WAMP |
| `composer not found` | Download and install from getcomposer.org |
| `npm not found` | Install Node.js from nodejs.org |
| `Connection refused (MySQL)` | Make sure WAMP's MySQL service is running (green icon in tray) |
| `SQLSTATE[1049] Unknown database` | Create `lms_db` in phpMyAdmin first |
| `php artisan key:generate` fails | Run `composer install` first |
| Pages show blank | Run `npm run build` — assets not compiled yet |
| `Vite manifest not found` | Run `npm run build` or `npm run dev` |

---

## 📌 Quick Command Reference

```bash
# Full fresh setup
composer install
npm install
copy .env.example .env
php artisan key:generate
# [Edit .env with DB details]
php artisan migrate
npm run build
php artisan serve

# Daily development
php artisan serve        # Terminal 1
npm run dev              # Terminal 2

# If you change DB schema
php artisan migrate

# Reset everything (DANGER: deletes all data)
php artisan migrate:fresh
```
