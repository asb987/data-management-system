<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


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

Route::get('/', [AuthController::class,'index'])->name('/');
Route::post('validate_login', [AuthController::class,'validate_login'])->name('validate_login');
Route::get('logout', [AuthController::class,'logout'])->name('logout');

Route::get('dashboard', [DashboardController::class,'index']);

Route::get('users', [UserController::class, 'index']);
Route::get('createuser', [UserController::class, 'registrationForm']);
Route::post('createuser', [UserController::class, 'createUser']);
Route::get('updateUser/{id}', [UserController::class, 'updateUser']);
Route::post('update/{id}', [UserController::class, 'update']);
Route::get('restore/{id}', [UserController::class, 'restore']);
Route::get('deleteUser/{id}', [UserController::class, 'deleteUser']);

// category route
Route::get('category', [CategoryController::class, 'index'])->middleware('guard');
Route::get('createcategory', [CategoryController::class, 'categoryform'])->middleware('guard');
Route::post('createcategory', [CategoryController::class, 'create'])->middleware('guard');
Route::get('updatecategory/{id}', [CategoryController::class, 'updatecategory'])->middleware('guard');
Route::post('updatecategory/{id}', [CategoryController::class, 'update'])->middleware('guard');
Route::get('restoreCategory/{id}', [CategoryController::class, 'restore'])->middleware('guard');
Route::post('deleteCategory', [CategoryController::class, 'deleteCategory'])->middleware('guard');
Route::post('getCategoryDetail', [CategoryController::class, 'getCategoryDetail'])->middleware('guard');

// product route
Route::get('product', [ProductController::class, 'index'])->middleware('guard');
Route::get('createproduct', [ProductController::class, 'productform'])->middleware('guard');
Route::post('createproduct', [ProductController::class, 'create'])->middleware('guard');
Route::get('updateproduct/{id}', [ProductController::class, 'updateproduct'])->middleware('guard');
Route::post('updateproduct/{id}', [ProductController::class, 'update'])->middleware('guard');
Route::get('restoreproduct/{id}', [ProductController::class, 'restore'])->middleware('guard');
Route::post('deleteproduct', [ProductController::class, 'deleteproduct'])->middleware('guard');
Route::post('getProductdetail', [ProductController::class, 'getProductdetail'])->middleware('guard');