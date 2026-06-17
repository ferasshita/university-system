<?php

use App\Http\Controllers\Api\AuditLogController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\CampusController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\SubsystemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('employees', EmployeeController::class)->except(['create', 'edit']);
Route::apiResource('faculties', FacultyController::class)->except(['create', 'edit']);
Route::apiResource('departments', DepartmentController::class)->except(['create', 'edit']);
Route::apiResource('campuses', CampusController::class)->except(['create', 'edit']);
Route::apiResource('buildings', BuildingController::class)->except(['create', 'edit']);
Route::apiResource('rooms', RoomController::class)->except(['create', 'edit']);
Route::apiResource('subsystems', SubsystemController::class)->except(['create', 'edit']);

// Subsystem toggle
Route::patch('subsystems/{subsystem}/toggle', [SubsystemController::class, 'toggleActive']);

// Audit logs (read-only)
Route::get('audit-logs', [AuditLogController::class, 'index']);
Route::get('audit-logs/{id}', [AuditLogController::class, 'show']);

// Notifications
Route::get('notifications', [NotificationController::class, 'index']);
Route::post('notifications/send', [NotificationController::class, 'send']);
