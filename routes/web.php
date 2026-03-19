<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LiveClassController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
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
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

    // Enrollments
    Route::resource('enrollments', EnrollmentController::class)->only(['index']);
    Route::get('/enrollments', function () {
        return Inertia::render('Admissions/Index');
    })->name('enrollments.index');

    // Live Classes
    Route::get('/live-classes', function () {
        return Inertia::render('LiveClasses/Index');
    })->name('live-classes.index');

    // Study Materials
    Route::get('/materials', function () {
        return Inertia::render('Materials/Index');
    })->name('materials.index');

    // Fees
    Route::get('/fees', function () {
        return Inertia::render('Fees/Index');
    })->name('fees.index');

    // Payments (PhonePe)
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments',       [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');
});

require __DIR__.'/auth.php';
