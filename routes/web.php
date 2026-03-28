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
    return view('welcome');
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
    Route::get('/admissions/{admission}/checkout', [AdmissionController::class, 'checkout'])->name('admissions.checkout');
    Route::post('/admissions/{admission}/pay', [AdmissionController::class, 'pay'])->name('admissions.pay');
    Route::post('/admissions/validate-coupon', [AdmissionController::class, 'validateCoupon'])->name('admissions.validate-coupon');

    // Enrollments (Aliases for Admissions)
    Route::get('/enrollments', [AdmissionController::class, 'index'])->name('enrollments.index');
    Route::post('/courses/{course}/progress', [CourseController::class, 'updateProgress'])->name('courses.progress.update');

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
    Route::get('api/courses/{course}', [AdminCourseController::class, 'apiShow'])->name('api.courses.show');
    Route::get('api/trainers/courses', [AdminCourseController::class, 'apiTrainerCourses'])->name('api.trainers.courses');

    // Students
    Route::get('students', [AdminStudentController::class, 'index'])->name('students.index');

    // Trainers
    Route::resource('trainers', \App\Http\Controllers\Admin\AdminTrainerController::class)->only(['index', 'create', 'store']);

    // Admissions
    Route::get('admissions', [AdminAdmissionController::class, 'index'])->name('admissions.index');
    Route::post('admissions/{admission}/approve', [AdminAdmissionController::class, 'approve'])->name('admissions.approve');
    Route::post('admissions/{admission}/reject',  [AdminAdmissionController::class, 'reject'])->name('admissions.reject');
    Route::post('admissions/{admission}/assign-batch', [AdminAdmissionController::class, 'assignBatch'])->name('admissions.assign-batch');
    Route::post('admissions/{admission}/certificate', [AdminAdmissionController::class, 'uploadCertificate'])->name('admissions.certificate');

    // Fees
    Route::get('fees', [AdminFeeController::class, 'index'])->name('fees.index');
    Route::post('fees/{fee}/mark-paid', [AdminFeeController::class, 'markPaid'])->name('fees.markPaid');

    // Live Classes
    Route::resource('live-classes', AdminLiveClassController::class);
    Route::post('live-classes/coupons', [AdminLiveClassController::class, 'storeCoupon'])->name('live-classes.coupons.store');

    // Study Materials
    Route::resource('study-materials', AdminStudyMaterialController::class);
});

// ── Trainer Routes ──────────────────────────────────────────────────────────────
use App\Http\Controllers\Trainer\TrainerController;
use App\Http\Controllers\Trainer\TrainerCourseController;
use App\Http\Controllers\Trainer\TrainerLiveClassController;
use App\Http\Controllers\Trainer\TrainerStudyMaterialController;

Route::middleware(['auth', 'role:trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/', [TrainerController::class, 'index'])->name('dashboard');
    
    // Trainer exclusive module routes
    Route::resource('courses', TrainerCourseController::class);
    Route::post('/courses/{course}/lessons', [TrainerCourseController::class, 'storeLesson'])->name('courses.lessons.store');
    Route::delete('/courses/{course}/lessons/{lesson}', [TrainerCourseController::class, 'destroyLesson'])->name('courses.lessons.destroy');
    Route::post('/courses/{course}/materials', [TrainerCourseController::class, 'storeMaterial'])->name('courses.materials.store');
    Route::delete('/courses/{course}/materials/{material}', [TrainerCourseController::class, 'destroyMaterial'])->name('courses.materials.destroy');
    
    Route::resource('live-classes', TrainerLiveClassController::class)->except(['destroy']);
    Route::post('live-classes/branches', [TrainerLiveClassController::class, 'storeBranch'])->name('live-classes.branches.store');
    Route::post('live-classes/coupons', [TrainerLiveClassController::class, 'storeCoupon'])->name('live-classes.coupons.store');

    // Study Materials Management (Trainer)
    Route::resource('study-materials', TrainerStudyMaterialController::class)->names([
        'index' => 'study-materials.index',
        'create' => 'study-materials.create',
        'store' => 'study-materials.store',
        'destroy' => 'study-materials.destroy',
    ]);
});

require __DIR__.'/auth.php';
