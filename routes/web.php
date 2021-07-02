<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;

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

Route::group(['prefix' => 'user'], function () {
    Route::get('edit/{id}', [UserController::class, 'edit_form'])->middleware('auth')->name('user.edit');
    Route::post('edit/{id}', [UserController::class, 'edit_action'])->middleware('auth')->name('user.edit_action');
});
Route::group(['prefix' => 'company'], function () {
    Route::get('list', [CompanyController::class, 'list'])->middleware('auth')->name('company.list');
    Route::post('detail', [CompanyController::class, 'detail'])->middleware('auth')->name('company.detail');
    Route::post('create', [CompanyController::class, 'create'])->middleware('auth')->name('company.create');
    Route::post('update', [CompanyController::class, 'update'])->middleware('auth')->name('company.update');
    Route::post('delete', [CompanyController::class, 'delete'])->middleware('auth')->name('company.delete');
    Route::post('departments', [CompanyController::class, 'departments'])->middleware('auth')->name('company.departments');
});
Route::group(['prefix' => 'department'], function () {
    Route::get('list', [DepartmentController::class, 'list'])->middleware('auth')->name('department.list');
    Route::post('detail', [DepartmentController::class, 'detail'])->middleware('auth')->name('department.detail');
    Route::post('create', [DepartmentController::class, 'create'])->middleware('auth')->name('department.create');
    Route::post('update', [DepartmentController::class, 'update'])->middleware('auth')->name('department.update');
    Route::post('delete', [DepartmentController::class, 'delete'])->middleware('auth')->name('department.delete');
});
Route::group(['prefix' => 'user'], function () {
    Route::get('list', [UserController::class, 'list'])->middleware('auth')->name('user.list');
    Route::post('detail', [UserController::class, 'detail'])->middleware('auth')->name('user.detail');
    Route::post('create', [UserController::class, 'create'])->middleware('auth')->name('user.create');
    Route::post('update', [UserController::class, 'update'])->middleware('auth')->name('user.update');
    Route::post('delete', [UserController::class, 'delete'])->middleware('auth')->name('user.delete');
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
