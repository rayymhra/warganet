<?php
use App\Http\Controllers\{AuthController, PublicController};
use App\Http\Controllers\Resident\ReportController as ResidentReport;
use App\Http\Controllers\Admin\{DashboardController, CrudController, ReportController as AdminReport};
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/schedules', [PublicController::class, 'schedules']);
Route::get('/announcements', [PublicController::class, 'announcements']);
Route::get('/emergency-alerts', [PublicController::class, 'alerts']);
Route::get('/businesses', [PublicController::class, 'businesses']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm']);
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth', CheckRole::class . ':resident'])->prefix('resident')->group(function () {
    Route::get('/dashboard', [ResidentReport::class, 'dashboard']);
    Route::get('/reports/create', [ResidentReport::class, 'create']);
    Route::post('/reports', [ResidentReport::class, 'store']);
});

Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/reports', [AdminReport::class, 'index']);
    Route::get('/reports/{report}', [AdminReport::class, 'show']);
    Route::patch('/reports/{report}/status', [AdminReport::class, 'status']);
    Route::get('/external-alerts', [AdminReport::class, 'external']);
    Route::get('/{res}', [CrudController::class, 'index'])->whereIn('res', ['schedules', 'announcements', 'businesses']);
    Route::post('/{res}', [CrudController::class, 'store'])->whereIn('res', ['schedules', 'announcements', 'businesses']);
    Route::delete('/{res}/{id}', [CrudController::class, 'destroy'])->whereIn('res', ['schedules', 'announcements', 'businesses']);
});