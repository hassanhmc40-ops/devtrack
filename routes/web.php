<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes (provided by Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Protected Routes (require authentication)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |----------------------------------------------------------------------
    | Dashboard (US2 - shows user's projects with task counts)
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard', [ProjectController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/my-tasks', [TaskController::class, 'myTasks'])
        ->name('my-tasks');

    Route::get('/team-members', [MemberController::class, 'index'])
        ->name('team-members');

    Route::get('/analytics', [ProjectController::class, 'analytics'])
        ->name('analytics');

    /*
    |----------------------------------------------------------------------
    | Projects Routes (US3, US4, US5, US6)
    |----------------------------------------------------------------------
    */
    
    // Standard resource routes (CRUD)
    Route::resource('projects', ProjectController::class);
    // This creates:
    // GET    /projects              → index   (projects.index)
    // GET    /projects/create       → create  (projects.create)
    // POST   /projects              → store   (projects.store)
    // GET    /projects/{project}    → show    (projects.show)
    // GET    /projects/{project}/edit → edit  (projects.edit)
    // PUT    /projects/{project}    → update  (projects.update)
    // DELETE /projects/{project}    → destroy (projects.destroy) - soft delete

    // Archive & Restore routes
    Route::get('/projects-archives', [ProjectController::class, 'archives'])
        ->name('projects.archives');
    
    Route::post('/projects/{id}/restore', [ProjectController::class, 'restore'])
        ->name('projects.restore');
    
    Route::delete('/projects/{id}/force-delete', [ProjectController::class, 'forceDelete'])
        ->name('projects.forceDelete');

    /*
    |----------------------------------------------------------------------
    | Project Members Routes (US7 - add/remove members)
    |----------------------------------------------------------------------
    */
    
    Route::post('/projects/{project}/members', [MemberController::class, 'store'])
        ->name('projects.members.store');
    
    Route::delete('/projects/{project}/members/{user}', [MemberController::class, 'destroy'])
        ->name('projects.members.destroy');

    /*
    |----------------------------------------------------------------------
    | Tasks Routes (US8, US9, US10, US11, US12)
    |----------------------------------------------------------------------
    */
    
    // Nested resource routes (tasks belong to projects)
    Route::resource('projects.tasks', TaskController::class)
        ->except(['index']); // Tasks shown in project.show, not separate index
    // This creates:
    // GET    /projects/{project}/tasks/create       → create (projects.tasks.create)
    // POST   /projects/{project}/tasks              → store  (projects.tasks.store)
    // GET    /projects/{project}/tasks/{task}       → show   (projects.tasks.show)
    // GET    /projects/{project}/tasks/{task}/edit  → edit   (projects.tasks.edit)
    // PUT    /projects/{project}/tasks/{task}       → update (projects.tasks.update)
    // DELETE /projects/{project}/tasks/{task}       → destroy (projects.tasks.destroy)

    // Task status update (US11 - developers can only change status)
    Route::patch('/projects/{project}/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.status');

    /*
    |----------------------------------------------------------------------
    | Profile / Settings Routes
    |----------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});
