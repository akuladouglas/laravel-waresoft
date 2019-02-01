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
  Route::match(['get', 'post'], '/sync-by-id', 'OrderController@syncOrderById');
  Route::match(['get', 'post'], '/sync-updated', 'OrderController@syncUpdatedOrders');
  Route::match(['get', 'post'], '/test', 'OrderController@getDashboard');
  Route::match(['get', 'post'], '/view/{id}', 'OrderController@viewOrder');
  Route::match(['get', 'post'], '/refresh', 'OrderController@refresh');
  Route::match(['get', 'post'], '/deliverys', 'OrderController@deliverys');
  Route::match(['get', 'post'], '/undo-for-delivery/{order_id}', 'OrderController@undoForDelivery');
  
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
  
  Route::match(['get', 'post'], '/fullfillment/{start_date}/{end_date}', 'CyfeDashboardController@fullfillmentRate');
  Route::match(['get', 'post'], '/paidsalesamount/{start_date}/{end_date}', 'CyfeDashboardController@paidSalesAmount');
  Route::match(['get', 'post'], '/averagebasket/{start_date}/{end_date}', 'CyfeDashboardController@averageBasketExVat');
  Route::match(['get', 'post'], '/deliveredorders/{start_date}/{end_date}', 'CyfeDashboardController@deliveredOrders');
  Route::match(['get', 'post'], '/revenuedeliveredorders/{start_date}/{end_date}', 'CyfeDashboardController@revenueDeliveredOrdersExVat');
  Route::match(['get', 'post'], '/offlinesales/{start_date}/{end_date}', 'CyfeDashboardController@offlineSales');
  Route::match(['get', 'post'], '/onlinesales/{start_date}/{end_date}', 'CyfeDashboardController@onlineSales');
  Route::match(['get', 'post'], '/untaggedsales/{start_date}/{end_date}', 'CyfeDashboardController@untaggedSales');
  Route::match(['get', 'post'], '/pendingorders/{start_date}/{end_date}', 'CyfeDashboardController@pendingOrders');
  Route::match(['get', 'post'], '/pendingdeliveries/{start_date}/{end_date}', 'CyfeDashboardController@pendingDeliveries');
  Route::match(['get', 'post'], '/salesperstaff/{start_date}/{end_date}', 'CyfeDashboardController@salesExVatPerStaff');
  Route::match(['get', 'post'], '/orderstoday', 'CyfeDashboardController@numberOfOrdersToday');
  Route::match(['get', 'post'], '/salestoday/{start_date}/{end_date}', 'CyfeDashboardController@salesTodayExVat');
  Route::match(['get', 'post'], '/pendingDeliveriesStaff/{start_date}/{end_date}', 'CyfeDashboardController@pendingDeliveriesExVatPerStaff');
  Route::match(['get', 'post'], '/dailytransactionbreakdown/{start_date}/{end_date}', 'CyfeDashboardController@dailyTransactionBreakdown');      
  Route::match(['get', 'post'], '/onlinesalesdailytransactionbreakdown/{start_date}/{end_date}', 'CyfeDashboardController@onelineSalesDailyTransactionBreakdown');      
  Route::match(['get', 'post'], '/cancelledorders/{start_date}/{end_date}', 'CyfeDashboardController@cancelledOrders');
  Route::match(['get', 'post'], '/breakdownbyvendor/{start_date}/{end_date}', 'CyfeDashboardController@breakdownByVendor');
  Route::match(['get', 'post'], '/breakdownbyproduct/{start_date}/{end_date}', 'CyfeDashboardController@breakdownByProduct');
  Route::match(['get', 'post'], '/breakdownbysku/{start_date}/{end_date}', 'CyfeDashboardController@breakdownBySku');
  Route::match(['get', 'post'], '/returningvsnew/{start_date}/{end_date}', 'CyfeDashboardController@breakdownReturningVsNew');
  Route::match(['get', 'post'], '/dailybreakdownbyvendor/{start_date}/{end_date}', 'CyfeDashboardController@dailyBreakdownByVendor');
  Route::match(['get', 'post'], '/dailybreakdownbyproduct/{start_date}/{end_date}', 'CyfeDashboardController@dailyBreakdownByProduct');
  Route::match(['get', 'post'], '/dailybreakdownbysku/{start_date}/{end_date}', 'CyfeDashboardController@dailyBreakdownBySku');
  Route::match(['get', 'post'], '/getpaymentpostdata/{string}', 'CyfeDashboardController@getPaymentPost');
  Route::match(['get', 'post'], '/breakdownbyfullfillmentstatus/{start_date}/{end_date}', 'CyfeDashboardController@fullfillmentStatusBreakdown');
  Route::match(['get', 'post'], '/breakdownbyfinancialstatus/{start_date}/{end_date}', 'CyfeDashboardController@financialStatusBreakdown');
  Route::match(['get', 'post'], '/untaggedsalesorderids/{start_date}/{end_date}', 'CyfeDashboardController@untaggedSalesOrderIds');
  Route::match(['get', 'post'], '/wholesaleagentsales/{start_date}/{end_date}', 'CyfeDashboardController@wholesaleAgentSales');
  
  Route::match(['get', 'post'], '/test', 'CyfeDashboardController@test'); 
  Route::match(['get', 'post'], '/testFunnel/{public_token}/{start_date}/{end_date}', 'CyfeDashboardController@testFunnel'); 
  
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
  Route::match(['get', 'post'], '/download-invoice/{order_id}', 'DeliveryController@downloadInvoice');
  Route::match(['get', 'post'], '/mark-dispatched/{order_id}', 'DeliveryController@markDispatched');
});

Route::group(array('prefix' => 'leads'), function () {
  Route::match(['get', 'post'], '/', 'LeadsController@index');
  Route::match(['get', 'post'], '/stats', 'LeadsController@stats');
  Route::match(['get', 'post'], '/add', 'LeadsController@add');
  Route::match(['get', 'post'], '/process-add', 'LeadsController@processAdd');
  Route::match(['get', 'post'], '/mark-converted/{leadid}', 'LeadsController@markConverted');
});

Route::group(array('prefix' => 'api'), function () {
  Route::any('/short-code-callback', 'ApiController@shortCodeCallback');
  Route::any('/test', 'ApiController@test');
});


Route::group(array('prefix' => 'product'), function () {
  Route::match(['get', 'post'], '/', 'ProductController@getProducts');
});

Route::group(array('prefix' => 'payment'), function () {
  Route::match(['get', 'post'], '/list', 'PaymentController@paymentsList');
  Route::match(['get', 'post'], '/mpesa', 'PaymentController@requestMpesa');
  Route::match(['get', 'post'], '/suregifts', 'PaymentController@suregifts');
  Route::match(['get', 'post'], '/suregifts/process/{voucher_code}', 'PaymentController@processSuregiftsCode');
  Route::match(['get', 'post'], '/suregifts/redeem/{voucher_code}/{amount_to_use}', 'PaymentController@redeemSuregiftsCode');
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
  Route::match(['get', 'post'], '/sms-redemptions', 'RewardController@smsRedemptions');
  Route::match(['get', 'post'], '/create-coupon-sms/{id}', 'RewardController@createCouponSms');  
  Route::match(['get', 'post'], '/sync-customer-points', 'RewardController@syncCustomerPoints');
  Route::match(['get', 'post'], '/send-points-sms', 'RewardController@sendLoyaltyStatementSms');
  
});

Route::group(array('prefix' => 'queues'), function () {
  Route::match(['get', 'post'], '/rewards-sms', 'QueuesController@rewardsSmsQueue');
});