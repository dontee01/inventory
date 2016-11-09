<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/home', function () {
    return view('home');
});
Route::get('/upload-form', function () {
    return view('file-upload');
});

Route::post('/upload', 'FileEntryController@add');


Route::get('/', 'UserController@index');

Route::post('/', 'UserController@login');

Route::get('/logout', 'UserController@logout');

// items
Route::get('/items', 'ItemController@index');

Route::get('/item/add', 'ItemController@show_add');

Route::post('/item/add', 'ItemController@add');

Route::get('/item/edit/{id}', 'ItemController@show_edit');

Route::post('/item/edit/{id}', 'ItemController@edit');

Route::post('/item/delete/{id}', 'ItemController@delete');

// customers
Route::get('/customers', 'CustomerController@index');

Route::get('/customer/add', 'CustomerController@show_add');

Route::post('/customer/add', 'CustomerController@add');

Route::get('/customer/edit/{id}', 'CustomerController@show_edit');

Route::post('/customer/edit/{id}', 'CustomerController@edit');

Route::post('/customer/delete/{id}', 'CustomerController@delete');

// suppliers
Route::get('/suppliers', 'SupplierController@index');

Route::get('/supplier/add', 'SupplierController@show_add');

Route::post('/supplier/add', 'SupplierController@add');

Route::get('/supplier/edit/{id}', 'SupplierController@show_edit');

Route::post('/supplier/edit/{id}', 'SupplierController@edit');

Route::post('/supplier/delete/{id}', 'SupplierController@delete');

// drivers
Route::get('/drivers', 'DriverController@index');

Route::get('/driver/add', 'DriverController@show_add');

Route::post('/driver/add', 'DriverController@add');

Route::get('/driver/edit/{id}', 'DriverController@show_edit');

Route::post('/driver/edit/{id}', 'DriverController@edit');

Route::post('/driver/delete/{id}', 'DriverController@delete');

// users
Route::get('/users', 'StaffController@index');

Route::get('/user/add', 'StaffController@show_add');

Route::post('/user/add', 'StaffController@add');

Route::get('/user/edit/{id}', 'StaffController@show_edit');

Route::post('/user/edit/{id}', 'StaffController@edit');

Route::post('/user/delete/{id}', 'StaffController@delete');


Route::get('/order', 'OrderController@index');

Route::get('/order/{id}', 'OrderController@populate');


Route::post('/cart/add', 'CartController@add');

// Route::resource('users', 'UserController');