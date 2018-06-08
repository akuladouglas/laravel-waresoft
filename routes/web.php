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

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/test', function () {
    return view("test");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(array('prefix' => 'order'), function () {
  
  Route::match(['get', 'post'], '/sync', 'OrderController@syncOrders');
  
  Route::get('restaurants/crop-gallery-thumb/{restid}/{id}', 'ManagerRestaurantController@getEditGalleryImage');
  
});