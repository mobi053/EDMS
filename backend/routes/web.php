<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// Route::get('users', [UserController::class, 'index'])->name('users.index');
// Route::get('users/create', [UserController::class, 'create'])->name('users.create');
// Route::post('users/storedata', [UserController::class, 'storedata'])->name('users.storedata');
// Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
// Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
// Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
// Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::group(['prefix' => '/users'], function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/list', [UserController::class, 'list'])->name('users.list');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
});