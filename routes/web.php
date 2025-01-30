<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin', [\App\Http\Controllers\DashboardController::class, 'dashboardAdmin'])->name('dashboard.admin');

    Route::resource('mbkm/about-app', \App\Http\Controllers\AboutAppController::class);

    Route::get('admin/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('admin/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('admin/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('profile/upload', [\App\Http\Controllers\ProfileController::class, 'upload'])->name('profile.upload');
    Route::delete('profile/delete-file', [\App\Http\Controllers\ProfileController::class, 'deleteFile'])->name('profile.deleteFile');
    Route::post('/temp/storage', [\App\Http\Controllers\StorageController::class, 'store'])->name('storage.store');
    Route::delete('/temp/storage', [\App\Http\Controllers\StorageController::class, 'destroy'])->name('storage.destroy');
    Route::get('/temp/storage/{path}', [\App\Http\Controllers\StorageController::class, 'show'])->name('storage.show');

    Route::resource('admin/role-permissions/permission', \App\Http\Controllers\RolePermission\PermissionController::class);
    Route::post('admin/role-permissions/permission/json', [\App\Http\Controllers\RolePermission\PermissionController::class, 'json'])->name('permission.json');

    Route::resource('admin/role-permissions/role', \App\Http\Controllers\RolePermission\RoleController::class);
    Route::post('admin/role-permissions/role/json', [\App\Http\Controllers\RolePermission\RoleController::class, 'json'])->name('role.json');

    Route::resource('admin/role-permissions/user', \App\Http\Controllers\UserController::class);
    Route::post('admin/role-permissions/user/json', [\App\Http\Controllers\UserController::class, 'json'])->name('user.json');

    Route::resource('courses', \App\Http\Controllers\CourseController::class);
    Route::get('courses/trashed', [\App\Http\Controllers\CourseController::class, 'trashed'])->name('courses.trashed');
    Route::post('courses/{id}/restore', [\App\Http\Controllers\CourseController::class, 'restore'])->name('courses.restore');
    Route::delete('courses/{id}/force-delete', [\App\Http\Controllers\CourseController::class, 'forceDelete'])->name('courses.forceDelete');

    Route::resource('lecturers', \App\Http\Controllers\LecturersController::class);
    Route::get('lecturers/trashed', [\App\Http\Controllers\LecturersController::class, 'trashed'])->name('lecturers.trashed');
    Route::post('lecturers/{id}/restore', [\App\Http\Controllers\LecturersController::class, 'restore'])->name('lecturers.restore');
    Route::delete('lecturers/{id}/force-delete', [\App\Http\Controllers\LecturersController::class, 'forceDelete'])->name('lecturers.forceDelete');
    
    Route::resource('general_information', \App\Http\Controllers\GeneralInformationController::class);
    Route::get('general_information/trashed', [\App\Http\Controllers\GeneralInformationController::class, 'trashed'])->name('general_information.trashed');
    Route::post('general_information/{id}/restore', [\App\Http\Controllers\GeneralInformationController::class, 'restore'])->name('general_information.restore');
    Route::delete('general_information/{id}/force-delete', [\App\Http\Controllers\GeneralInformationController::class, 'forceDelete'])->name('general_information.forceDelete');

    Route::resource('virtuals', \App\Http\Controllers\VirtualController::class);
    Route::get('virtuals/trashed', [\App\Http\Controllers\VirtualController::class, 'trashed'])->name('virtuals.trashed');
    Route::post('virtuals/{id}/restore', [\App\Http\Controllers\VirtualController::class, 'restore'])->name('virtuals.restore');
    Route::delete('virtuals/{id}/force-delete', [\App\Http\Controllers\VirtualController::class, 'forceDelete'])->name('virtuals.forceDelete');


    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::get('categories/trashed', [\App\Http\Controllers\CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::post('categories/{id}/restore', [\App\Http\Controllers\CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{id}/force-delete', [\App\Http\Controllers\CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
});

require __DIR__ . '/auth.php';
