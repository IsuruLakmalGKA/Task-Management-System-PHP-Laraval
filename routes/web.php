<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;


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
//
//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', [TaskController::class, 'index']);
//Route::get('/', [LoginController::class, 'login']);
//Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/fetch-users', [TaskController::class, 'fetchUsers'])->name('fetchUsers');
Route::post('/store', [TaskController::class,'store'])->name('store');
Route::get('/fetch-all', [TaskController::class, 'fetchAll'])->name('fetchAll');
Route::get('/edit', [TaskController::class, 'edit'])->name('edit');
Route::post('/update', [TaskController::class,'update'])->name( 'update');
Route::post('/delete', [TaskController::class,'delete'])->name('delete');

// Route::post('/store', [EmployeeController::class,'store'])->name('store');
// Route::get('/fetch-all', [EmployeeController::class, 'fetchAll'])->name('fetchAll');
// Route::get('/edit', [EmployeeController::class, 'edit'])->name('edit');
// Route::post('/update', [EmployeeController::class,'update'])->name( 'update');
// Route::post('/delete', [EmployeeController::class,'delete'])->name('delete');
