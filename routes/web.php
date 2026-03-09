<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CaseController;
use App\Http\Controllers\Admin\JudgeController as AdminJudgeController;
use App\Http\Controllers\Admin\LawyerController as AdminLawyerController;
use App\Http\Controllers\Citizen\CitizenController;
use App\Http\Controllers\Judge\JudgeController;
use App\Http\Controllers\Lawyer\LawyerController;

Route::get('/', function () {
    return view('welcome');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    $totalUsers    = \App\Models\User::count();
    $totalCases    = \App\Models\DivorceCase::count();
    $pendingCases  = \App\Models\DivorceCase::where('status', 'pending')->count();
    $approvedCases = \App\Models\DivorceCase::where('status', 'approved')->count();
    return view('admin.dashboard', compact(
        'totalUsers', 'totalCases', 'pendingCases', 'approvedCases'
    ));
})->middleware(['auth', 'role:admin']);

// Admin User Management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Admin Case Management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/cases', [CaseController::class, 'index'])->name('admin.cases.index');
    Route::get('/cases/{divorceCase}', [CaseController::class, 'show'])->name('admin.cases.show');
    Route::patch('/cases/{divorceCase}/status', [CaseController::class, 'updateStatus'])->name('admin.cases.updateStatus');
    Route::patch('/cases/{divorceCase}/judge', [CaseController::class, 'assignJudge'])->name('admin.cases.assignJudge');
    Route::delete('/cases/{divorceCase}', [CaseController::class, 'destroy'])->name('admin.cases.destroy');
});

// Admin Judges
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/judges', [AdminJudgeController::class, 'index'])->name('admin.judges.index');
});

// Admin Lawyers
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/lawyers', [AdminLawyerController::class, 'index'])->name('admin.lawyers.index');
});

// Citizen Routes
Route::middleware(['auth', 'role:citizen'])->prefix('citizen')->group(function () {
    Route::get('/dashboard', [CitizenController::class, 'dashboard'])->name('citizen.dashboard');
    Route::get('/cases', [CitizenController::class, 'myCases'])->name('citizen.cases');
    Route::get('/cases/create', [CitizenController::class, 'create'])->name('citizen.cases.create');
    Route::post('/cases', [CitizenController::class, 'store'])->name('citizen.cases.store');
    Route::get('/cases/{divorceCase}', [CitizenController::class, 'show'])->name('citizen.cases.show');
    Route::get('/notifications', [\App\Http\Controllers\Citizen\NotificationController::class, 'index'])->name('citizen.notifications');
});
// Judge Routes
Route::middleware(['auth', 'role:judge'])->prefix('judge')->group(function () {
    Route::get('/dashboard', [JudgeController::class, 'dashboard'])->name('judge.dashboard');
    Route::get('/cases', [JudgeController::class, 'myCases'])->name('judge.cases');
    Route::get('/cases/{divorceCase}', [JudgeController::class, 'show'])->name('judge.cases.show');
    Route::patch('/cases/{divorceCase}/status', [JudgeController::class, 'updateStatus'])->name('judge.cases.updateStatus');
});

// Lawyer Routes
Route::middleware(['auth', 'role:lawyer'])->prefix('lawyer')->group(function () {
    Route::get('/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');
    Route::get('/cases', [LawyerController::class, 'cases'])->name('lawyer.cases');
});

// Fallback dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
