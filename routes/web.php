<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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

Route::get('/' , [TestController::class, 'index'])->name('homepage');
Route::group(['prefix' => 'test'], function () {
    Route::get('/' , [TestController::class, 'test_index'])->name('test.index');
    Route::get('companies' , [TestController::class, 'companies'])->name('test.companies');
    Route::get('login' , [TestController::class, 'login'])->name('test.login');
    Route::get('departments' , [TestController::class, 'departments'])->name('test.departments');
});
