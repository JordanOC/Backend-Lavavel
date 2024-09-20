<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [ProductController::class, 'index'])->name('home');

Route::get('/adicionar-itens', [ProductController::class, 'create'])->name('adicionar.itens');

Route::get('/products/list', [ProductController::class, 'index'])->name('products.list');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::resource('products', ProductController::class)->except(['show']);
Route::get('/products/category/{category}', [ProductController::class, 'searchByCategory'])->name('products.category');


Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::resource('categories', CategoryController::class);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users', [UserController::class, 'store'])->name('users.store');
// Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');

Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('/test-queue', function () {
    Job::dispatch();

    return 'Job foi enviado para a fila!';
});


