<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;

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

Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('homepage');

Route::post('getDepartmentsOfCompany', [CompanyController::class, 'getDepartmentsOfCompany'])->middleware('auth')->name('getDepartmentsOfCompany');
Route::post('getCompanyDetail', [CompanyController::class, 'getCompanyDetail'])->middleware('auth')->name('getCompanyDetail');
Route::post('deleteCompany', [CompanyController::class, 'deleteCompany'])->middleware('auth')->name('deleteCompany');

Route::group(['prefix' => 'user'], function () {
    Route::get('edit/{id}', [UserController::class, 'edit_form'])->middleware('auth')->name('user.edit');
    Route::post('edit/{id}', [UserController::class, 'edit_action'])->middleware('auth')->name('user.edit_action');
});
Route::group(['prefix' => 'company'], function () {
    Route::get('list', [CompanyController::class, 'list'])->middleware('auth')->name('company.list');
    Route::get('create', [CompanyController::class, 'create'])->middleware('auth')->name('company.create');
    Route::post('edit', [CompanyController::class, 'edit_action'])->middleware('auth')->name('company.edit_action');
});
Route::get('/login', [AuthController::class, 'login_form'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login_action'])->middleware('guest')->name('user.login_action');
Route::get('/register', [AuthController::class, 'register_form'])->middleware('guest')->name('user.register_form');
Route::post('/register', [AuthController::class, 'register_action'])->middleware('guest')->name('user.register_action');
Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('user.activate');

Route::post('/logout', [UserController::class, 'logout_action'])->middleware('auth')->name('user.logout_action');
Route::get('/logout', [UserController::class, 'logout_action'])->middleware('auth')->name('user.logout_action');



Route::group(['prefix' => 'test'], function () {
    Route::get('/', [TestController::class, 'test_index'])->name('test.index');
    Route::get('/test2', [TestController::class, 'index'])->name('test.index2');
    Route::get('companies', [TestController::class, 'companies'])->name('test.companies');
    Route::get('login', [TestController::class, 'login'])->name('test.login');
    Route::get('departments', [TestController::class, 'departments'])->name('test.departments');
});
