<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

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

Route::get('/' , [TestController::class, 'index'])->middleware('auth')->name('homepage');

Route::get('/login', [UserController::class, 'login_form'])->middleware('guest')->name('login');
Route::post('/login', [UserController::class, 'login_action'])->middleware('guest')->name('user.login_action');
Route::get('/register', [UserController::class, 'register_form'])->middleware('guest')->name('user.register_form');
Route::post('/register', [UserController::class, 'register_action'])->middleware('guest')->name('user.register_action');
Route::get('/activate/{token}', [UserController::class, 'activate'])->name('user.activate');
Route::post('/logout', [UserController::class, 'logout_action'])->middleware('auth')->name('user.logout_action');






Route::group(['prefix' => 'test'], function () {
    Route::get('/' , [TestController::class, 'test_index'])->name('test.index');
    Route::get('companies' , [TestController::class, 'companies'])->name('test.companies');
    Route::get('login' , [TestController::class, 'login'])->name('test.login');
    Route::get('departments' , [TestController::class, 'departments'])->name('test.departments');
});
