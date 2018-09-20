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

Route::get('/', function (){
  return redirect('/login');
});

Route::match(['get', 'post'], '/test', function () {
    return view("test");
});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(array('prefix' => 'order'), function () {
  Route::match(['get', 'post'], '/', 'OrderController@getOrders');
  Route::match(['get', 'post'], '/sync', 'OrderController@syncOrders');
  Route::match(['get', 'post'], '/sync-updated', 'OrderController@syncUpdatedOrders');
  Route::match(['get', 'post'], '/test', 'OrderController@getDashboard');
  Route::match(['get', 'post'], '/view/{id}', 'OrderController@viewOrder');
  Route::match(['get', 'post'], '/refresh', 'OrderController@refresh');
});

Route::group(array('prefix' => 'dashboard'), function () {
  Route::match(['get', 'post'], '/', 'DashboardController@getDashboardInfo');
  Route::match(['get', 'post'], '/getinfo', 'DashboardController@getDashboardInfo');
  Route::match(['get', 'post'], '/fullfillment', 'DashboardController@fullfillmentRate');
  Route::match(['get', 'post'], '/paidsalesamount', 'DashboardController@paidSalesAmount');
  Route::match(['get', 'post'], '/averagebasket', 'DashboardController@averageBasketExVat');
  Route::match(['get', 'post'], '/deliveredorders', 'DashboardController@deliveredOrders');
  Route::match(['get', 'post'], '/revenuedeliveredorders', 'DashboardController@revenueDeliveredOrdersExVat');
  Route::match(['get', 'post'], '/offlinesales', 'DashboardController@offlineSales');
  Route::match(['get', 'post'], '/onlinesales', 'DashboardController@onlineSales');
  Route::match(['get', 'post'], '/pendingorders', 'DashboardController@pendingOrders');
  Route::match(['get', 'post'], '/pendingdeliveries', 'DashboardController@pendingDeliveries');
  Route::match(['get', 'post'], '/salesperstaff', 'DashboardController@salesExVatPerStaff');
  Route::match(['get', 'post'], '/orderstoday', 'DashboardController@numberOfOrdersToday');
  Route::match(['get', 'post'], '/salestoday', 'DashboardController@salesTodayExVat');  
  Route::match(['get', 'post'], '/test', 'DashboardController@test');
  
});

Route::group(array('prefix' => 'cyfe-dash'), function () {
  
  Route::match(['get', 'post'], '/fullfillment', 'CyfeDashboardController@fullfillmentRate');
  Route::match(['get', 'post'], '/paidsalesamount', 'CyfeDashboardController@paidSalesAmount');
  Route::match(['get', 'post'], '/averagebasket', 'CyfeDashboardController@averageBasketExVat');
  Route::match(['get', 'post'], '/deliveredorders', 'CyfeDashboardController@deliveredOrders');
  Route::match(['get', 'post'], '/revenuedeliveredorders', 'CyfeDashboardController@revenueDeliveredOrdersExVat');
  Route::match(['get', 'post'], '/offlinesales', 'CyfeDashboardController@offlineSales');
  Route::match(['get', 'post'], '/onlinesales', 'CyfeDashboardController@onlineSales');
  Route::match(['get', 'post'], '/untaggedsales', 'CyfeDashboardController@untaggedSales');
  Route::match(['get', 'post'], '/pendingorders', 'CyfeDashboardController@pendingOrders');
  Route::match(['get', 'post'], '/pendingdeliveries', 'CyfeDashboardController@pendingDeliveries');
  Route::match(['get', 'post'], '/salesperstaff', 'CyfeDashboardController@salesExVatPerStaff');
  Route::match(['get', 'post'], '/orderstoday', 'CyfeDashboardController@numberOfOrdersToday');
  Route::match(['get', 'post'], '/salestoday', 'CyfeDashboardController@salesTodayExVat');
  Route::match(['get', 'post'], '/pendingDeliveriesStaff', 'CyfeDashboardController@pendingDeliveriesExVatPerStaff');
  Route::match(['get', 'post'], '/dailytransactionbreakdown', 'CyfeDashboardController@dailyTransactionBreakdown');      
  Route::match(['get', 'post'], '/onlinesalesdailytransactionbreakdown', 'CyfeDashboardController@onelineSalesDailyTransactionBreakdown');      
  Route::match(['get', 'post'], '/cancelledorders', 'CyfeDashboardController@cancelledOrders');
  Route::match(['get', 'post'], '/breakdownbyvendor', 'CyfeDashboardController@breakdownByVendor');
  Route::match(['get', 'post'], '/breakdownbyproduct', 'CyfeDashboardController@breakdownByProduct');
  Route::match(['get', 'post'], '/breakdownbysku', 'CyfeDashboardController@breakdownBySku');
  Route::match(['get', 'post'], '/returningvsnew', 'CyfeDashboardController@breakdownReturningVsNew');
  Route::match(['get', 'post'], '/dailybreakdownbyvendor', 'CyfeDashboardController@dailyBreakdownByVendor');
  Route::match(['get', 'post'], '/dailybreakdownbyproduct', 'CyfeDashboardController@dailyBreakdownByProduct');
  Route::match(['get', 'post'], '/dailybreakdownbysku', 'CyfeDashboardController@dailyBreakdownBySku');
  Route::match(['get', 'post'], '/getpaymentpostdata/{string}', 'CyfeDashboardController@getPaymentPost');
  Route::match(['get', 'post'], '/breakdownbyfullfillmentstatus', 'CyfeDashboardController@fullfillmentStatusBreakdown');
  Route::match(['get', 'post'], '/breakdownbyfinancialstatus', 'CyfeDashboardController@financialStatusBreakdown');
  Route::match(['get', 'post'], '/untaggedsalesorderids', 'CyfeDashboardController@untaggedSalesOrderIds');
  
  
  Route::match(['get', 'post'], '/test', 'CyfeDashboardController@test'); 
  
});

Route::group(array('prefix' => 'delivery'), function () {
  Route::match(['get', 'post'], '/', 'DeliveryController@getDeliverys');
  Route::match(['get', 'post'], '/create/{order_id}', 'DeliveryController@createDelivery');
  Route::match(['get', 'post'], '/assign-rider', 'DeliveryController@assignRider');
  Route::match(['get', 'post'], '/mark-delivered', 'DeliveryController@markDelivered');
  Route::match(['get', 'post'], '/mark-paid', 'DeliveryController@markPaid');
  Route::match(['get', 'post'], '/edit/{order_id}', 'DeliveryController@edit');
  Route::match(['get', 'post'], '/commit-stock/{order_id}', 'DeliveryController@commitStock');
  Route::match(['get', 'post'], '/post-edit', 'DeliveryController@postEdit');
  Route::match(['get', 'post'], '/update/{order_id}', 'DeliveryController@updateDelivery');
});

Route::group(array('prefix' => 'leads'), function () {
  Route::match(['get', 'post'], '/', 'LeadsController@index');
  Route::match(['get', 'post'], '/stats', 'LeadsController@stats');
  Route::match(['get', 'post'], '/add', 'LeadsController@add');
  Route::match(['get', 'post'], '/process-add', 'LeadsController@processAdd');
  Route::match(['get', 'post'], '/mark-converted', 'LeadsController@markConverted');
});

Route::group(array('prefix' => 'product'), function () {
  Route::match(['get', 'post'], '/', 'ProductController@getProducts');
});

Route::group(array('prefix' => 'payment'), function () {
  Route::match(['get', 'post'], '/list', 'PaymentController@paymentsList');
  Route::match(['get', 'post'], '/mpesa', 'PaymentController@requestMpesa');
  Route::match(['get', 'post'], '/suregifts', 'PaymentController@suregifts');
  Route::match(['get', 'post'], '/pushstats', 'PaymentController@mpesaPushStats');
  Route::match(['get', 'post'], '/process-stk-push/{id}', 'PaymentController@processStkPush');
  Route::match(['get', 'post'], '/process-send-pay-info/{id}', 'PaymentController@processSendPayInfo');  
});

Route::group(array('prefix' => 'pay'), function () {
  Route::match(['get', 'post'], '/{order_id}', 'PayController@processPayRequest');
});

Route::group(array('prefix' => 'combination'), function () {
  Route::match(['get', 'post'], '/', 'CombinationController@getCombinations');
});

Route::group(array('prefix' => 'stock'), function () {
  Route::match(['get', 'post'], '/', 'StockController@getStocks');
});

Route::group(array('prefix' => 'report'), function () {
  Route::match(['get', 'post'], '/', 'ReportController@getReports');
  Route::match(['get', 'post'], '/vendor-sales', 'ReportController@getVendorReports');
});

Route::group(array('prefix' => 'customer'), function () {
  Route::match(['get', 'post'], '/', 'CustomerController@getCustomers');
  Route::match(['get', 'post'], '/sync-customer', 'CustomerController@syncCustomers');
  Route::match(['get', 'post'], '/refresh', 'CustomerController@refresh');
});

Route::group(array('prefix' => 'reward'), function () { 
  
  Route::match(['get', 'post'], '/coupon', 'RewardController@getCoupon');
  Route::match(['get', 'post'], '/customers', 'RewardController@getCustomers');
  Route::match(['get', 'post'], '/activitys', 'RewardController@getActivitys');
  Route::match(['get', 'post'], '/sms', 'RewardController@getSms');
  Route::match(['get', 'post'], '/sync-customers', 'RewardController@syncCustomers');
  Route::match(['get', 'post'], '/sync-activitys', 'RewardController@syncActivitys');
  Route::match(['get', 'post'], '/queue-points-sms', 'RewardController@queuePointsBalanceSms');
  Route::match(['get', 'post'], '/sync-coupons', 'RewardController@syncCoupons');
  
  Route::match(['get', 'post'], '/create-coupon-sms/{id}', 'RewardController@createCouponSms');
  
  
});

Route::group(array('prefix' => 'queues'), function () {
  Route::match(['get', 'post'], '/rewards-sms', 'QueuesController@rewardsSmsQueue');
});