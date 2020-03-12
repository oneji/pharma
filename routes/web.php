<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

// Users
Route::resource('users', 'UserController');
Route::put('users/{user}/status/{status}', 'UserController@changeStatus')->name('users.status');

// Brands
Route::get('brands', 'BrandController@index')->name('brands.index');
Route::post('brands', 'BrandController@store')->name('brands.store');

// Medicine
Route::get('medicine', 'MedicineController@index')->name('medicine.index');
Route::post('medicine', 'MedicineController@store')->name('medicine.store');


