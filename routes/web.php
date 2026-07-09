<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduledJobController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

    Route::resource('workflows', WorkflowController::class);
    Route::post('/workflows/{workflow}/run', [WorkflowController::class, 'run'])->name('workflows.run');
    Route::resource('email-center', EmailTemplateController::class);
    Route::get('/email-logs', [EmailTemplateController::class, 'logs'])->name('email.logs');

    Route::resource('notifications', NotificationController::class);
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');

    Route::resource('scheduled-jobs', ScheduledJobController::class);
    Route::post('/scheduled-jobs/{scheduledJob}/run', [ScheduledJobController::class, 'run'])
    ->name('scheduled-jobs.run');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('tasks', TaskController::class);

    Route::prefix('reports')
    ->name('reports.')
    ->group(function () {

        Route::get('/', [ReportController::class,'index'])->name('index');

        // Route::get('/sales',[ReportController::class,'sales'])->name('sales');

        // Route::get('/payments',[ReportController::class,'payments'])->name('payments');

        // Route::get('/customers',[ReportController::class,'customers'])->name('customers');

        // Route::get('/products',[ReportController::class,'products'])->name('products');

        // Route::get('/invoices',[ReportController::class,'invoices'])->name('invoices');

    });
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
});

require __DIR__.'/auth.php';
