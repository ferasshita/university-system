<?php

use App\Http\Controllers\Api\AuditLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\CampusController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubsystemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/password/email', [AuthController::class, 'sendResetLink']);

Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/me', [AuthController::class, 'me']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('employees', EmployeeController::class)->except(['create', 'edit']);
    Route::apiResource('students', StudentController::class)->except(['create', 'edit']);
    Route::apiResource('faculties', FacultyController::class)->except(['create', 'edit']);
    Route::apiResource('departments', DepartmentController::class)->except(['create', 'edit']);
    Route::apiResource('campuses', CampusController::class)->except(['create', 'edit']);
    Route::apiResource('buildings', BuildingController::class)->except(['create', 'edit']);
    Route::apiResource('rooms', RoomController::class)->except(['create', 'edit']);
    Route::apiResource('subsystems', SubsystemController::class)->except(['create', 'edit']);

    Route::patch('subsystems/{subsystem}/toggle', [SubsystemController::class, 'toggleActive']);

    Route::get('audit-logs', [AuditLogController::class, 'index']);
    Route::get('audit-logs/{auditLog}', [AuditLogController::class, 'show']);

    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/send', [NotificationController::class, 'send']);
});
