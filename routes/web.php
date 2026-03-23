<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LiveClassController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudyMaterialController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Landing / Welcome
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Courses
    Route::resource('courses', CourseController::class)->only(['index', 'show']);

    // Admissions
    Route::resource('admissions', AdmissionController::class)->only(['index', 'create', 'store']);

    // Enrollments (Aliases for Admissions)
    Route::get('/enrollments', [AdmissionController::class, 'index'])->name('enrollments.index');

    // Live Classes
    Route::get('/live-classes', [LiveClassController::class, 'index'])->name('live-classes.index');

    // Study Materials
    Route::get('/materials', [StudyMaterialController::class, 'index'])->name('materials.index');

    // Fees
    Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');

    // Payments (PhonePe)
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments',       [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');
});

// ── Admin Routes ────────────────────────────────────────────────────────────────
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminAdmissionController;
use App\Http\Controllers\Admin\AdminFeeController;
use App\Http\Controllers\Admin\AdminLiveClassController;
use App\Http\Controllers\Admin\AdminStudyMaterialController;
use App\Http\Middleware\AdminMiddleware;

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',          [AdminController::class, 'index'])->name('dashboard');

    // Courses CRUD
    Route::resource('courses', AdminCourseController::class)->names([
        'index'   => 'courses.index',
        'create'  => 'courses.create',
        'store'   => 'courses.store',
        'edit'    => 'courses.edit',
        'update'  => 'courses.update',
        'destroy' => 'courses.destroy',
    ]);

    // Students
    Route::get('students', [AdminStudentController::class, 'index'])->name('students.index');

    // Admissions
    Route::get('admissions', [AdminAdmissionController::class, 'index'])->name('admissions.index');
    Route::post('admissions/{admission}/approve', [AdminAdmissionController::class, 'approve'])->name('admissions.approve');
    Route::post('admissions/{admission}/reject',  [AdminAdmissionController::class, 'reject'])->name('admissions.reject');

    // Fees
    Route::get('fees', [AdminFeeController::class, 'index'])->name('fees.index');
    Route::post('fees/{fee}/mark-paid', [AdminFeeController::class, 'markPaid'])->name('fees.markPaid');

    // Live Classes
    Route::resource('live-classes', AdminLiveClassController::class);

    // Study Materials
    Route::resource('study-materials', AdminStudyMaterialController::class);
});

// ── Trainer Routes ──────────────────────────────────────────────────────────────
use App\Http\Controllers\Trainer\TrainerController;

Route::middleware(['auth', 'role:trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/', [TrainerController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
