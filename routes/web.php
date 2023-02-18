<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Member\LoginController as MemberLoginController;
use App\Http\Controllers\Member\MovieController as MemberMovieController;
use App\Http\Controllers\Member\PricingController;
use App\Http\Controllers\Member\RegisterController;
use App\Http\Controllers\Member\TransactionController as MemberTransactionController;
use App\Http\Controllers\Member\UserPremiumController;
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

// Route::get('/', function () {
//     return view('admin.dashboard');
// });

// Route::middleware('guest')->group(function () {
// });

Route::view('/', 'index');

Route::get('login', [MemberLoginController::class, 'index'])->name('member.login');
Route::post('login', [MemberLoginController::class, 'auth'])->name('member.login.auth');

// Route::middleware('guest')->group(function () {
Route::get('admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'authenticate'])->name('admin.login.auth');

Route::get('/register', [RegisterController::class, 'index'])->name('member.register');
Route::post('/register', [RegisterController::class, 'store'])->name('member.register.store');
// });

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::view('/', 'admin.dashboard')->name('admin.dashboard');

    Route::group(['prefix' => 'movie'], function () {
        Route::get('/', [MovieController::class, 'index'])->name('admin.movie');
        Route::get('/create', [MovieController::class, 'create'])->name('admin.movie.create');
        Route::post('/store', [MovieController::class, 'store'])->name('admin.movie.store');
        Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('admin.movie.edit');
        Route::put('/update/{id}', [MovieController::class, 'update'])->name('admin.movie.update');
        Route::delete('/destroy/{id}', [MovieController::class, 'destroy'])->name('admin.movie.destroy');
    });
    Route::get('/transaction', [TransactionController::class, 'index'])->name('admin.transaction');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::group(['prefix' => 'member', 'middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('member.dashboard');
    Route::get('/movie/{id}', [MemberMovieController::class, 'show'])->name('member.movie.detail');
    Route::get('/movie/{id}/watch', [MemberMovieController::class, 'watch'])->name('member.movie.watch');

    Route::post('/transaction', [MemberTransactionController::class, 'store'])->name('member.transaction');
    Route::get('/subscription', [UserPremiumController::class, 'index'])->name('member.user_premium.index');
    Route::delete('/subscription/{id}', [UserPremiumController::class, 'destroy'])->name('member.user_premium.destroy');

    Route::get('/logout', [MemberLoginController::class, 'logout'])->name('member.logout');
});

Route::view('/payment-finish', 'member.payment-finish')->name('member.payment.finish');
