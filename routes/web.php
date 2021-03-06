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

Route::get('new-client-requests', 'ClientController@index')->name('newClients.index');
Route::get('new-client', 'ClientController@newClient')->name('newClients.newClient');
Route::post('new-client-request', 'ClientController@saveRequest')->name('newClients.saveRequest');

Route::middleware([ 'check_password_changed' ])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    // New clients
    Route::post('new-client', 'ClientController@store')->name('newClients.store');

    // Users
    Route::middleware([ 'permission:read-users' ])->group(function() {
        Route::resource('users', 'UserController');
        Route::put('users/{user}/status/{status}', 'UserController@changeStatus')->name('users.status');
    });
    Route::get('clients', 'UserController@getClients')->name('users.clients');
    
    // Debtors
    Route::get('debtors', [
        'middleware' => 'permission:read-debtors',
        'uses' => 'UserController@debtors'
    ])->name('users.debtors');

    // Creditors
    Route::get('creditors', 'CreditorController@index')->name('creditors.index');
    Route::get('creditors/{id}', 'CreditorController@getById')->name('creditors.getById');
    Route::post('creditors', 'CreditorController@store')->name('creditors.store');
    Route::post('creditors/importExcel', 'CreditorController@importExcel')->name('creditors.excel');

    // Brands
    Route::get('brands', 'BrandController@index')->name('brands.index');
    Route::post('brands', 'BrandController@store')->name('brands.store');
    Route::put('brands/{id}', 'BrandController@update')->name('brands.update');
    Route::get('brands/getAll', 'BrandController@getAllBrandsAjax')->name('brands.getAll');

    // Medicine
    Route::get('medicine', 'MedicineController@index')->name('medicine.index');
    Route::post('medicine', 'MedicineController@store')->name('medicine.store');
    Route::put('medicine/{id}', 'MedicineController@update')->name('medicine.update');
    Route::get('medicine/getAll', 'MedicineController@getAllMedicineAjax')->name('medicine.getAll');

    // Companies
    Route::get('companies', 'CompanyController@index')->name('companies.index');
    Route::post('companies', 'CompanyController@store')->name('companies.store');
    Route::put('companies/{id}', 'CompanyController@update')->name('companies.update');

    // Price lists
    Route::get('price-lists', 'PriceListController@index')->name('price_lists.index');
    Route::get('price-lists/create', 'PriceListController@create')->name('price_lists.create');
    Route::get('price-lists/{id}', 'PriceListController@view')->name('price_lists.view');
    Route::get('price-lists/{id}/edit', 'PriceListController@edit')->name('price_lists.edit');

    Route::post('price-lists', 'PriceListController@createPriceList')->name('price_lists.store');
    Route::put('price-lists/{id}/update', 'PriceListController@update')->name('price_lists.update');

    // Requests
    Route::get('requests', 'RequestController@index')->name('requests.index');
    Route::get('requests/create', 'RequestController@create')->name('requests.create');
    Route::get('requests/edit/{id}', 'RequestController@edit')->name('requests.edit');
    Route::get('requests/view/{id}', 'RequestController@getById')->name('requests.view');
    Route::get('requests/status/{status}', 'RequestController@getByStatus')->name('requests.getByStatus');
    
    Route::post('requests', 'RequestController@store')->name('requests.store');
    Route::post('requests/pay/{id}', 'RequestController@pay')->name('requests.pay');
    Route::post('requests/setPriority/{id}', 'RequestController@setPriority')->name('requests.priority');
    Route::post('requests/setPaymentDeadline/{id}', 'RequestController@setPaymentDeadline')->name('requests.paymentDeadline');
    
    Route::delete('requests/removeItem/{id}', 'RequestController@removeItem')->name('requests.removeItem');
    
    Route::put('requests/updateItem/{id}', 'RequestController@updateItem')->name('requests.updateItem');
    Route::put('requests/{id}/status/{status}', 'RequestController@changeStatus')->name('requests.status');
    Route::put('requests/{id}/cancel', 'RequestController@cancel')->name('requests.cancel');

    // ACL
    Route::get('acl', 'AclController@index')->name('acl.index');
    Route::post('acl/set', 'AclController@setPermissionsToRoles')->name('acl.set');
    Route::post('acl/role', 'AclController@storeRole')->name('acl.storeRole');
    Route::post('acl/permission', 'AclController@storePermission')->name('acl.storePermission');
});

// Password
Route::get('password', 'PasswordController@editPassword')->name('password.edit');
Route::put('password/change', 'PasswordController@changePassword')->name('password.change');

