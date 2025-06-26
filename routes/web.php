<?php

use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('/');

Route::resource('tasks', TaskController::class);

Route::resource('task_statuses', TaskStatusController::class);

Route::resource('labels', LabelController::class);

require __DIR__ . '/auth.php';
