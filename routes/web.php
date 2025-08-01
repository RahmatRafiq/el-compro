<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['inertia'])->group(function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/lecturers', [\App\Http\Controllers\HomeController::class, 'lecturers'])->name('home.lecturers');
    Route::get('/courses', [\App\Http\Controllers\HomeController::class, 'courses'])->name('home.courses');
    Route::get('/articles', [\App\Http\Controllers\HomeController::class, 'articles'])->name('home.articles');
    Route::get('/articles/{slug}', [\App\Http\Controllers\HomeController::class, 'show'])->name('home.articles.show');
    Route::get('/articles/category/{name}', [\App\Http\Controllers\HomeController::class, 'articlesByCategory'])->name('home.articles.category');
    Route::get('/virtual-tours', [\App\Http\Controllers\HomeController::class, 'virtualTours'])->name('virtualTours');
    Route::get('/virtual-tours/{slug}', [\App\Http\Controllers\HomeController::class, 'virtualTourDetail'])->name('virtualTourDetail');
    Route::get('/about-us', [\App\Http\Controllers\HomeController::class, 'aboutApp'])->name('aboutApp');

});

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/admin', [\App\Http\Controllers\DashboardController::class, 'dashboardAdmin'])->name('dashboard.admin');

        Route::resource('about-app', \App\Http\Controllers\AboutAppController::class);
        Route::delete('about-app/delete-file', [\App\Http\Controllers\AboutAppController::class, 'deleteFile'])->name('aboutApp.deleteFile');

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
        Route::post('lecturers/upload', [\App\Http\Controllers\LecturersController::class, 'upload'])->name('lecturers.upload');
        Route::delete('lecturers/delete-file', [\App\Http\Controllers\LecturersController::class, 'deleteFile'])->name('lecturers.deleteFile');

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

        Route::resource('articles', \App\Http\Controllers\ArticleController::class);
        Route::get('articles/trashed', [\App\Http\Controllers\ArticleController::class, 'trashed'])->name('articles.trashed');
        Route::post('articles/{id}/restore', [\App\Http\Controllers\ArticleController::class, 'restore'])->name('articles.restore');
        Route::delete('articles/{id}/force-delete', [\App\Http\Controllers\ArticleController::class, 'forceDelete'])->name('articles.forceDelete');
        Route::delete('articles/delete-file', [\App\Http\Controllers\ArticleController::class, 'deleteFile'])->name('articles.deleteFile');

        Route::get('graduate_learning_outcomes/json', [\App\Http\Controllers\GraduateLearningOutcomeController::class, 'json'])->name('graduate_learning_outcomes.json');
        Route::resource('graduate_learning_outcomes', \App\Http\Controllers\GraduateLearningOutcomeController::class);
        Route::post('graduate_learning_outcomes/{id}/restore', [\App\Http\Controllers\GraduateLearningOutcomeController::class, 'restore'])->name('graduate_learning_outcomes.restore');
        Route::delete('graduate_learning_outcomes/{id}/forceDelete', [\App\Http\Controllers\GraduateLearningOutcomeController::class, 'forceDelete'])->name('graduate_learning_outcomes.forceDelete');

    });
});

require __DIR__ . '/auth.php';
