<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SubCategoryController;
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



Route::group(['prefix' => 'admin'], function () {
    Route::group([['middleware' => 'admin.guest']], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    Route::group([['middleware' => 'admin.auth']], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        // category route
        Route::group(['prefix' => 'category'], function () {
            Route::get('/index', [CategoryController::class, 'index'])->name('admin.category.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
            Route::get('/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        });
        // subcategory routr
        Route::group(['prefix' => 'subcategory'], function () {
            Route::get('/index', [SubCategoryController::class, 'index'])->name('admin.subcategory.index');
            Route::get('/create', [SubCategoryController::class, 'create'])->name('admin.subcategory.create');
            Route::post('/store', [SubCategoryController::class, 'store'])->name('admin.subcategory.store');
            Route::get('/edit/{id}', [SubCategoryController::class, 'edit'])->name('admin.subcategory.edit');
            Route::post('/update/{id}', [SubCategoryController::class, 'update'])->name('admin.subcategory.update');
            Route::get('/destroy/{id}', [SubCategoryController::class, 'destroy'])->name('admin.subcategory.destroy');
        });
    });
});
