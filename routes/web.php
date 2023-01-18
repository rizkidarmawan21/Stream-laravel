<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate')->middleware('guest');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('authAdmin');

    Route::middleware(['authAdmin'])->group(function () {
        Route::view('/', 'admin.dashboard')->name('dashboard');

        Route::prefix('movie')->name('movie.')->group(function () {
            Route::get('/', [MovieController::class, 'index'])->name('index');
            Route::get('/create', [MovieController::class, 'create'])->name('create');
            Route::get('/edit/{movie}', [MovieController::class, 'edit'])->name('edit');
            Route::post('/store', [MovieController::class, 'store'])->name('store');
            Route::put('/update/{movie}', [MovieController::class, 'update'])->name('update');
            Route::delete('/delete/{movie}', [MovieController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('transaction')->name('transaction.')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('index');
        });
    });
});
