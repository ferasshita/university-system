<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\AuditLogController;
use App\Http\Controllers\Web\BuildingController;
use App\Http\Controllers\Web\CampusController;
use App\Http\Controllers\Web\DepartmentController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\FacultyController;
use App\Http\Controllers\Web\RoomController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\SubsystemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('faculties', FacultyController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('campuses', CampusController::class);
    Route::resource('buildings', BuildingController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('students', StudentController::class);
    Route::resource('subsystems', SubsystemController::class);
    Route::patch('subsystems/{subsystem}/toggle', [SubsystemController::class, 'toggleActive'])
        ->name('subsystems.toggle');
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
