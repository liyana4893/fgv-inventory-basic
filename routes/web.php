<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//inventory module

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index')->middleware('auth');
Route::get('/inventories/create', [InventoryController::class, 'create'])->name('inventories.create');
Route::post('/inventories/create', [InventoryController::class, 'store'])->name('inventories.store');
Route::get('/inventories/{inventory}', [InventoryController::class, 'show'])->name('inventories.show');
Route::get('/inventories/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventories.edit');
Route::post('/inventories/{inventory}/edit', [InventoryController::class, 'update'])->name('inventories.update');
Route::get('/inventories/{inventory}/delete', [InventoryController::class, 'delete'])->name('inventories.delete');

Route::get('/inventories/{inventory}/restore', [InventoryController::class, 'restore'])->name('inventories.restore');
Route::get('/inventories/{inventory}/force-delete', [InventoryController::class, 'forceDelete'])->name('inventories.forceDelete');


//shop module
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
Route::post('/shops/create', [ShopController::class, 'store'])->name('shops.store');
Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');
Route::get('/shops/{shop}/edit', [ShopController::class, 'edit'])->name('shops.edit');
Route::post('/shops/{shop}/edit', [ShopController::class, 'update'])->name('shops.update');
Route::get('/shops/{shop}/delete', [ShopController::class, 'delete'])->name('shops.delete');

//user
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/create', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/{user}/edit', [UserController::class, 'update'])->name('users.update');
Route::get('/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');