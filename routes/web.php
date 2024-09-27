<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\Home\HomeController;
use \App\Http\Middleware\AdminMiddleware;
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



Route::get('/',[HomeController::class,'home'])->name('home');
Route::get('/login',[HomeController::class,'login'])->name('login');
Route::post('/login' , [HomeController::class,'loginAdmin'])->name('admin.login');
Route::get('/logout', [HomeController::class,'logout'])->name('logout');
Route::get('/register', [HomeController::class,'register'])->name('register');
Route::post('/register', [HomeController::class,'registerUser'])->name('register.user');


Route::prefix('admin')->middleware([AdminMiddleware::class])->group(function () {
    Route::get('/index' , [AdminController::class, 'index'])->name('admin.index');
    Route::get('/create' , [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store' , [AdminController::class, 'store'])->name('admin.store');
    Route::get('/edit/{id}' , [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/update/{id}' , [AdminController::class, 'update'])->name('admin.update');
    Route::post('/delete/{id}', [AdminController::class, 'delete'])->name('delete');
});
