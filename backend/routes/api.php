<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DirController;
use App\Http\Controllers\Portal\CampusController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [LoginController::class, 'apiLogin']);
Route::post('/apiLogout', [LoginController::class, 'apiLogout']);

Route::get('/users', [UserController::class, 'alluser']);
Route::post('/adduser', [UserController::class, 'store']);
Route::delete('/destroy/{id}', [UserController::class, 'destroy']);

Route::post('/add_dir', [DirController::class, 'store']);
Route::get('/edit_dir/{id}', [DirController::class, 'edit']);
Route::put('/update_dir/{id}', [DirController::class, 'update']);

Route::put('/is_valid', [DirController::class, 'is_valid']);

Route::get('/view_dirs', [DirController::class, 'view_dirs']);
Route::delete('/dirdelete/{id}', [DirController::class, 'destroy']);

Route::group(['prefix' => '/classes'], function () {
    Route::get('/', [ClassController::class, 'index']); // Get all classes
    Route::get('/view_classes', [ClassController::class, 'view_classes']);
    Route::get('/{id}', [ClassController::class, 'show']); // Get a single class by ID
    Route::post('/store', [ClassController::class, 'store']); // Create a new class
    Route::get('/edit_class/{id}', [ClassController::class, 'edit']);
    Route::put('/update/{id}', [ClassController::class, 'update']);
    Route::delete('/delete/{id}', [ClassController::class, 'destroy']); // Delete a class by ID
    Route::post('/filter', [ClassController::class, 'filter']);
});

Route::group(['prefix' => '/sections'], function () {
    Route::get('/', [SectionController::class, 'index']); // Get all sections
    Route::get('/{id}', [SectionController::class, 'show']); // Get a single section by ID
    Route::post('/store', [SectionController::class, 'store']); // Create a new section
    Route::post('/update/{id}', [SectionController::class, 'update']); // Update a section by ID
    Route::delete('/delete/{id}', [SectionController::class, 'destroy']); // Delete a section by ID
});
Route::group(['prefix' => '/campuses'], function () {
    Route::get('/', [CampusController::class, 'index']); // Get all classes
    Route::get('/view_capmuses', [CampusController::class, 'view_capmuses']);
    Route::get('/{id}', [CampusController::class, 'show']); // Get a single class by ID
    Route::post('/store', [CampusController::class, 'store']); // Create a new class
    Route::get('/edit_campus/{id}', [CampusController::class, 'edit']);
    Route::put('/update/{id}', [CampusController::class, 'update']);
    Route::delete('/delete/{id}', [CampusController::class, 'destroy']); // Delete a class by ID
});