# EduLMS — Learning Management System

EduLMS is a modern, premium **Learning Management System (LMS)** built with **Laravel 11**, **React 18**, and **Inertia.js**. It is designed to provide a seamless experience for both instructors and students, featuring a design inspired by the high-end **Courseplus** theme.

---

## 🚀 Key Features

### 🎓 For Students
- **Course Catalog**: Browse courses with advanced search and category filtering.
- **Interactive Lessons**: High-quality video lessons with YouTube embedding.
- **Admission Management**: Multi-step admission forms with real-time status tracking.
- **Live Classes**: Integration with Zoom for real-time virtual classrooms.
- **Study Materials**: Searchable and downloadable grid for PDFs and documents.
- **Fee Management**: Track due fees and make payments via PhonePe.

### 🛠️ For Administrators
- **Admin Dashboard**: Overview of total students, courses, revenue, and pending admissions.
- **Course Management**: Full CRUD operations for courses, batches, and lessons.
- **Student & Admission Tracking**: Manage registrations and approve/reject applications.
- **Financial Overview**: Monitor fee records and payment statuses.

---

## 💻 Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | Laravel 11 (PHP 8.2+) |
| **Frontend** | React 18 + Inertia.js |
| **Styling** | Bootstrap 5 + Bootstrap Icons + Inter Font |
| **Database** | MySQL |
| **Integrations** | PhonePe (Payments), Zoom (Live Classes), YouTube (Video) |
| **Auth** | Laravel Breeze |

---

## 🛠️ Getting Started

### Prerequisites
- **WAMP/XAMPP** (Apache, MySQL, PHP 8.2+)
- **Composer**
- **Node.js 18+** & **npm**
- **Git**

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/nerajlal/LMS.git
   cd LMS
   ```

2. **Install Backend Dependencies:**
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Configure your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.*

5. **Database Migration & Seeding:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build & Run:**
   - **Development:**
     ```bash
     # Terminal 1
     php artisan serve
     # Terminal 2
     npm run dev
     ```
   - **Production:**
     ```bash
     npm run build
     php artisan serve
     ```

---

## 📁 Project Structure

- `app/Http/Controllers/`: Backend logic for courses, admissions, and payments.
- `resources/js/Pages/`: React components for all project pages.
- `resources/js/Layouts/`: Shared layout components (Sidebar, Navbar).
- `database/migrations/`: Database schema definitions.
- `routes/web.php`: URL routing for the entire application.

---

## 🎨 Design System

The UI is meticulously crafted to match the **Courseplus** theme:
- **Primary Color**: `#2563eb` (Blue)
- **Background**: `#f3f4f6` (Light Gray)
- **Typography**: Inter (Google Fonts)

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).
