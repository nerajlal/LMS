# AI Development Prompt — EduLMS Project

> **Give this entire file to the AI on your WAMP device.** It contains everything the AI needs to understand the project, what has been built, the design reference, and what to do next.

---

## Who You Are & What This Project Is

You are an AI coding assistant helping build a **Learning Management System (LMS)** called **EduLMS**. The project is a Laravel 11 + React + Inertia.js application that has already been partially set up. Your job is to continue development, fix any issues, and bring the UI and functionality to a production-ready, premium quality.

---

## Design Reference (VERY IMPORTANT — Match This Exactly)

The UI must closely match the **Courseplus** theme:

- **Instructor Dashboard Reference:** https://demo.foxthemes.net/courseplus/instructor/dashboard.html
- **Student Dashboard Reference:** https://demo.foxthemes.net/courseplus/
- **More pages:** https://demo.foxthemes.net/courseplus/instructor/courses.html

**Study these pages carefully.** The exact colors and design system to use:

| Element | Value |
|---------|-------|
| Body background | `#f3f4f6` |
| Sidebar background | `#ffffff` |
| Sidebar border | `1px solid #e5e7eb` |
| Top navbar | `linear-gradient(to right, #3b82f6, #2563eb)` |
| Primary accent/button | `#2563eb` |
| Primary heading text | `#1f2937` |
| Body / muted text | `#6b7280` |
| Card background | `#ffffff` |
| Card shadow | `0 1px 3px rgba(0,0,0,0.08)` |
| Green indicator | `#10b981` |
| Amber indicator | `#f59e0b` |
| Pink indicator | `#ec4899` |
| Red live badge | `#ef4444` |
| Font | Inter (Google Fonts) |
| Icons | Bootstrap Icons (CDN) |

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 |
| Frontend | React 18 + Inertia.js |
| Styling | Bootstrap 5 (CDN) + Bootstrap Icons (CDN) + Inter (Google Fonts) |
| Database | MySQL (via WAMP) |
| Auth | Laravel Breeze (username/password — no OTP) |
| Video lessons | YouTube embeds (`<iframe>`) |
| Live classes | Zoom (API keys needed — create stub for now) |
| Payments | PhonePe Payment Gateway (stub — keys needed) |

---

## What Has Already Been Done

### Backend (Laravel)

- ✅ Laravel 11 project initialized
- ✅ Laravel Breeze installed with React + Inertia.js stack
- ✅ MySQL database configured in `.env` (`DB_DATABASE=lms_db`)
- ✅ All migrations created for these tables:
  - `users` (Laravel default)
  - `courses` (title, description, thumbnail, price, instructor_name)
  - `batches` (course_id FK, name, start_date, end_date, status)
  - `lessons` (course_id FK, title, video_url, order)
  - `admissions` (user_id FK, course_id FK, batch_id FK, status, details JSON)
  - `enrollments` (user_id FK, course_id FK, batch_id FK, status)
  - `payments` (user_id FK, amount, payment_id, status, type)
  - `fees` (user_id FK, total_amount, paid_amount, due_date, status)
- ✅ Eloquent models created with fillable + relationships:
  - `Course` → hasMany: Lesson, Batch, Admission, Enrollment
  - `Batch` → belongsTo: Course
  - `Lesson` → belongsTo: Course
  - `Admission` → belongsTo: User, Course, Batch
  - `Enrollment` → belongsTo: User, Course, Batch
  - `Payment` → belongsTo: User
  - `Fee` → belongsTo: User
- ✅ Controllers created with Inertia renders:
  - `CourseController` (index, show)
  - `AdmissionController` (index, create, store)
  - `PaymentController` (create, store, callback stub)
  - `FeeController` (stub)
  - `DashboardController` (stub)
  - `LiveClassController` (stub)
- ✅ `routes/web.php` fully set up with all routes:
  - `/dashboard`, `/courses`, `/courses/{id}`, `/admissions`, `/admissions/create`, `/live-classes`, `/materials`, `/fees`, `/payments/create`, `/payments/callback`

### Frontend (React + Inertia.js)

- ✅ Shared Layout: `resources/js/Layouts/LmsLayout.jsx`
  - White sidebar (collapsible) with nav links
  - Blue gradient top header with search + notification bell + logout
  - Matches Courseplus design

- ✅ Pages created:
  - `Pages/Auth/Login.jsx` — Split panel login (blue left + white form right)
  - `Pages/Dashboard.jsx` — Stats cards, course progress cards, upcoming classes
  - `Pages/Courses/Index.jsx` — Search bar + category filter + course card grid
  - `Pages/Courses/Show.jsx` — YouTube video player + tabbed (Overview/Curriculum/Materials) + enrollment sidebar
  - `Pages/Admissions/Create.jsx` — Multi-step admission form (personal info + course selection)
  - `Pages/Admissions/Index.jsx` — Application status table
  - `Pages/LiveClasses/Index.jsx` — Live Now section + upcoming schedule list
  - `Pages/Materials/Index.jsx` — Searchable download grid
  - `Pages/Fees/Index.jsx` — Summary cards + fee detail table with Pay Now

- ✅ Blade template (`resources/views/app.blade.php`) updated with:
  - Bootstrap 5 (CDN)
  - Bootstrap Icons (CDN)
  - Inter font (Google Fonts)
  - Global CSS (light theme body, scrollbar, etc.)

---

## What Still Needs To Be Done (Your Job)

### 🔴 Priority 1 — Get It Running

1. **Run migrations** (after creating `lms_db` in phpMyAdmin):
   ```bash
   php artisan migrate
   ```

2. **Build/compile frontend assets:**
   ```bash
   npm install
   npm run dev
   ```
   *(keep this running during development for hot reload)*

3. **Start the server:**
   ```bash
   php artisan serve
   ```

4. **Register a test user** at `http://localhost:8000/register` and verify all pages load.

---

### 🟡 Priority 2 — Fix & Polish UI (Most Important)

The pages are built but need polish to **exactly match the Courseplus theme**. Study the reference URLs above and do the following:

#### a) `LmsLayout.jsx` (Sidebar + Header)
- The sidebar should show icons + labels when expanded, icons only when collapsed
- Active nav item should have a blue left border + blue icon + blue text (like Courseplus)
- The top header must use the exact blue gradient: `linear-gradient(to right, #3b82f6, #2563eb)`
- Add a user avatar in the top right showing the user's name and profile photo placeholder

#### b) `Dashboard.jsx`
- Make stat cards exactly match Courseplus: white card, colored top border (4px), icon in colored circle
- Below stats: show a "Course Progress" section with a mini table listing enrolled courses + progress bar
- Add a "Recent Activity" or "Announcements" widget on the right

#### c) `Courses/Index.jsx`
- Add a hero/banner strip at top (like Courseplus) showing total courses
- Course cards should show rating stars (static: 4.5 ⭐), number of students, duration
- Add a skeleton loading state

#### d) `Courses/Show.jsx`
- Lesson list must show duration, a lock icon for locked lessons
- Add a "Course includes" section (hours of video, articles, downloads, certificate)
- Show instructor bio card with avatar

#### e) **Admin Panel (NEW — needs to be built)**
Build a simple admin area at `/admin`:
- **Admin Dashboard**: total stats (students, courses, revenue, admissions)
- **Manage Courses**: list all courses + Add/Edit/Delete
- **Manage Students**: list registered users
- **Manage Admissions**: approve/reject pending applications (change status)
- **Manage Fees**: see all fee records + mark as paid

Use the Courseplus instructor pages as reference:
https://demo.foxthemes.net/courseplus/instructor/dashboard.html
https://demo.foxthemes.net/courseplus/instructor/courses.html

The admin routes should be protected with a middleware that checks `is_admin` column on users table. Add `is_admin` boolean to the users migration/model.

#### f) **Seeders (Demo Data)**
Create a database seeder so we can populate demo data:
```bash
php artisan db:seed
```
Should create:
- 1 admin user (`admin@edulms.com` / `password`)
- 1 test student (`student@edulms.com` / `password`)
- 3-4 sample courses with batches and lessons
- 1-2 sample admissions with status `approved`

---

### 🟢 Priority 3 — Feature Completion

#### PhonePe Payment Integration
File: `app/Http/Controllers/PaymentController.php`

Add PhonePe payment gateway. Steps:
1. Install SDK: `composer require phonepe/payment-sdk-php` (or use cURL-based approach)
2. In `store()` method, initiate payment and redirect to PhonePe URL
3. In `callback()` method, verify signature and update `payments` table status
4. Add `.env` keys: `PHONEPE_MERCHANT_ID`, `PHONEPE_SALT_KEY`, `PHONEPE_ENV=sandbox`

PhonePe API docs: https://developer.phonepe.com/v1/reference/pay-api-1

#### Zoom Live Class Integration
File: `app/Http/Controllers/LiveClassController.php`

- Admin can create a live class (store meeting in `live_classes` table — create this migration)
- On the student side, show the Zoom meeting link
- Optional: use Zoom API to auto-create meetings
- Add `.env` keys: `ZOOM_API_KEY`, `ZOOM_API_SECRET`

#### YouTube Lesson Player
File: `Pages/Courses/Show.jsx`

- Already built with `<iframe>` embed
- Ensure it tracks which lesson was last watched (store in `progress` table — optional)
- Add autoplay to next lesson button

---

### 🔵 Priority 4 — Quality & Polish

- Add **form validation flash messages** (success/error toasts) after admission submission, fee payment, etc.
- Add **loading spinners** for Inertia page transitions
- Make the app fully **mobile responsive** (sidebar becomes a drawer on mobile)
- Add **breadcrumbs** on inner pages
- The **Register page** (`Pages/Auth/Register.jsx`) should match the same split-panel style as the Login page

---

## Key File Locations

```
resources/js/
  Layouts/
    LmsLayout.jsx          ← Main layout (sidebar + header)
  Pages/
    Auth/
      Login.jsx            ← Login page
      Register.jsx         ← Register page (needs restyling)
    Dashboard.jsx
    Courses/
      Index.jsx
      Show.jsx
    Admissions/
      Create.jsx
      Index.jsx
    LiveClasses/
      Index.jsx
    Materials/
      Index.jsx
    Fees/
      Index.jsx

app/Http/Controllers/
  CourseController.php
  AdmissionController.php
  PaymentController.php
  FeeController.php
  LiveClassController.php

database/migrations/
  (all 8 migration files)

routes/web.php             ← All routes defined here

resources/views/app.blade.php  ← CDN links + global CSS

.env                       ← DB credentials + API keys

SETUP.md                   ← Full setup instructions
```

---

## Important Notes for the AI

1. **Use Inertia.js** for all page navigation — do NOT use `axios` or `fetch` for page loads. Use `<Link>` from `@inertiajs/react` for links and `useForm` for forms.

2. **All React pages must use `LmsLayout`** as the wrapper component (already created).

3. **Bootstrap classes + inline styles are both used** — the existing code uses mostly inline styles for the Courseplus-exact look. Continue this pattern for consistency.

4. **No Tailwind** — the project does NOT use Tailwind. Use Bootstrap 5 grid (`row`, `col-*`) for layout and custom inline CSS for styling.

5. **PHP binary** — this device uses WAMP so use the regular `php` command (not XAMPP path).

6. **Bootstrap Icons** are loaded via CDN — use `<i className="bi bi-icon-name">` syntax in JSX.

7. **The project is on GitHub**: `https://github.com/nerajlal/LMS.git` — always `git pull` before starting work.

---

## Quick Start Commands for This Device

```bash
# Pull latest code
git pull

# Install/update dependencies
composer install
npm install

# Setup env (if not done)
copy .env.example .env
php artisan key:generate
# Edit .env: set DB_DATABASE=lms_db, DB_USERNAME=root, DB_PASSWORD=

# Create DB in phpMyAdmin, then:
php artisan migrate

# Optional: seed demo data (after creating seeders)
php artisan db:seed

# Development mode (run both simultaneously)
php artisan serve          # Terminal 1
npm run dev                # Terminal 2

# Production build
npm run build
php artisan serve
```

---

*This document was generated to hand off the EduLMS project to another AI assistant for continued development.*
