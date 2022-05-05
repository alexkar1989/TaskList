<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::group(['middleware' => 'auth'], function() {

    Route::get('/', [MainController::class, 'index'])->name('main');

    Route::get('/tasks', [TasksController::class, 'index'])->name('getTasks');
    Route::get('/task/{id}', [TasksController::class, 'show'])->name('taskInfo');
    Route::put('/task', [TasksController::class, 'store'])->name('taskStore');
    Route::post('/task/{id}', [TasksController::class, 'update'])->name('taskUpdate');
    Route::delete('/task/{id}', [TasksController::class, 'destroy'])->name('taskRemove');

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/tasks', [UserController::class, 'getTask'])->name('userTask');
    Route::post('/user/task/link', [UserController::class, 'linkTask'])->name('listTask');
    Route::post('/user/task/complete', [UserController::class, 'completeTask'])->name('completeTask');
    Route::post('/user/task/cancel', [UserController::class, 'cancelTask'])->name('cancelTask');
});

//Route::any('{any}', function () {
//    return View('index', ['auth_user' => auth()->user()]);
//})->where('any', '.*')->middleware('auth');
