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

    Route::get('/', [MainController::class, 'index']);
    Route::get('/usertasks', [UserController::class, 'index']);

    Route::get('/tasks', [TasksController::class, 'index']);
    Route::get('/task/{id}', [TasksController::class, 'show']);
    Route::put('/task', [TasksController::class, 'store']);
    Route::post('/task/{id}', [TasksController::class, 'update']);
    Route::delete('/task/{id}', [TasksController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/tasks', [UserController::class, 'getTask']);
});

//Route::any('{any}', function () {
//    return View('index', ['auth_user' => auth()->user()]);
//})->where('any', '.*')->middleware('auth');
