<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::controller(AuthController::class)->group(function(){
        Route::post('/logout', 'logoutUser');
    });

    Route::controller(ProjectController::class)->group(function(){
        Route::post('/projects', 'store');
        Route::put('/projects', 'update');
        Route::get('/projects', 'index');
        Route::post('/projects/pinned', 'pinnedProject');
        Route::get('/projects/{slug}', 'getProduct');
    });

    Route::controller(MemberController::class)->group(function(){
        Route::post('/members', 'store');
        Route::put('/members', 'update');
        Route::get('/members', 'index');
    });

    Route::controller(TaskController::class)->group(function(){
        Route::post('/tasks', 'store');
        Route::put('/tasks/not_started_to_pending', 'taskNotStartedToPending');
        Route::put('/tasks/not_started_to_completed', 'taskNotStartedToCompleted');
        Route::put('/tasks/pending_to_completed', 'taskPendingToCompleted');
        Route::put('/tasks/pending_to_not_started', 'taskPendingToNotStart');
        Route::put('/tasks/completed_to_pending', 'taskCompletedToPending');
        Route::put('/tasks/completed_to_not_started', 'taskCompletedToNotStart');
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
