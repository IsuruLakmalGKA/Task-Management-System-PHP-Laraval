<?php

use App\Http\Controllers\TaskController;
use App\Mail\TaskCreated;
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

//Route::get('/', [LoginController::class, 'login']);
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/fetch-users', [TaskController::class, 'fetchUsers'])->name('fetchUsers');
Route::post('/tasks/store', [TaskController::class,'store'])->name('store');
Route::get('/tasks/fetch-all', [TaskController::class, 'fetchAll'])->name('fetchAll');
Route::get('/tasks/edit', [TaskController::class, 'edit'])->name('edit');
Route::post('/tasks/update', [TaskController::class,'update'])->name( 'update');
Route::post('/tasks/delete', [TaskController::class,'delete'])->name('delete');
Route::post('/tasks/payment', [TaskController::class,'payment'])->name('payment');

Route::get('/tasks/store/mail', function(){
   $name = "Anushka Isuru";
   Mail::to('mailtrap.club@gmail.com')->send(new TaskCreated()); 
});

Route::get('/tasks/payment', 'App\Http\Controllers\StripeController@checkout')->name('checkout');
Route::post('/tasks/payment/test', 'App\Http\Controllers\StripeController@test');
Route::post('/tasks/payment/live', 'App\Http\Controllers\StripeController@live');
Route::get('/tasks/payment/success', 'App\Http\Controllers\StripeController@success')->name('success');

// Route::post('/store', [EmployeeController::class,'store'])->name('store');
// Route::get('/fetch-all', [EmployeeController::class, 'fetchAll'])->name('fetchAll');
// Route::get('/edit', [EmployeeController::class, 'edit'])->name('edit');
// Route::post('/update', [EmployeeController::class,'update'])->name( 'update');
// Route::post('/delete', [EmployeeController::class,'delete'])->name('delete');
