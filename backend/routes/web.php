<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Portal\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('users.login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');
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
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/assign-permission', [UserController::class, 'assign_permission'])->name('user.assign_permission');
    Route::get('/get-permissions/{userId}', [UserController::class, 'get_permission'])->name('user.getPermission');
});
Route::group(['prefix'=>'/permission'],function(){
    Route::get('/', [PermissionController::class,'index'])->name('permission.index');
    Route::get('/add',[PermissionController::class,'add'])->name('permission.add');
    Route::post('/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/list', [PermissionController::class, 'list'])->name('permission.list');
    Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::get('/delete/{id}', [PermissionController::class, 'delete'])->name('permission.delete');
    Route::post('/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
});