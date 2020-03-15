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

// Price lists
Route::get('price-lists', 'PriceListController@index')->name('price_lists.index');
Route::get('price-lists/create', 'PriceListController@create')->name('price_lists.create');
Route::get('price-lists/{id}', 'PriceListController@view')->name('price_lists.view');
Route::get('price-lists/{id}/edit', 'PriceListController@edit')->name('price_lists.edit');

Route::post('price-lists', 'PriceListController@createPriceList')->name('price_lists.store');
Route::put('price-lists/{id}/update', 'PriceListController@update')->name('price_lists.update');

// Password
Route::get('password', 'UserController@editPassword')->name('password.edit');
Route::put('password/change', 'UserController@changePassword')->name('password.change');

