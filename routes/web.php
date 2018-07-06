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
  Route::match(['get', 'post'], '/', 'OrderController@getOrders');
  Route::match(['get', 'post'], '/sync', 'OrderController@syncOrders');
});

Route::group(array('prefix' => 'delivery'), function () {
  Route::match(['get', 'post'], '/', 'DeliveryController@getDeliverys');
});

Route::group(array('prefix' => 'product'), function () {
  Route::match(['get', 'post'], '/', 'ProductController@getProducts');
});

Route::group(array('prefix' => 'combination'), function () {
  Route::match(['get', 'post'], '/', 'CombinationController@getCombinations');
});

Route::group(array('prefix' => 'stock'), function () {
  Route::match(['get', 'post'], '/', 'StockController@getStocks');
});

Route::group(array('prefix' => 'report'), function () {
  Route::match(['get', 'post'], '/', 'ReportController@getReports');
});

Route::group(array('prefix' => 'customer'), function () {
  Route::match(['get', 'post'], '/', 'CustomerController@getCustomers');
  Route::match(['get', 'post'], '/sync-customer', 'CustomerController@syncCustomers');
});

Route::group(array('prefix' => 'reward'), function () {
  Route::match(['get', 'post'], '/customers', 'RewardController@getCustomers');
  Route::match(['get', 'post'], '/activitys', 'RewardController@getActivitys');
  Route::match(['get', 'post'], '/sms', 'RewardController@getSms');
  Route::match(['get', 'post'], '/sync-customers', 'RewardController@syncCustomers');
  Route::match(['get', 'post'], '/sync-activitys', 'RewardController@syncActivitys');
  Route::match(['get', 'post'], '/queue-points-sms', 'RewardController@queuePointsBalanceSms');
});

Route::group(array('prefix' => 'queues'), function () {
  Route::match(['get', 'post'], '/rewards-sms', 'QueuesController@rewardsSmsQueue');
});