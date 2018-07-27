<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Lineitems;

class OrderReportService
{
    public $start_date;
    public $end_date;

    public function __construct()
    {
    }

    public function getFullfillmentRate()
    {
    }

    public function getMonthToDate()
    {
    }

    public function getAverageBasketSize()
    {
    }

    public function getDeliveredOrders()
    {
    }

    public function getRevenueExVat()
    {
    }

    public function offlineSales()
    {
    }

    public function getOnlineSales()
    {
    }

    public function getPendingOrders()
    {
    }

    public function getSalesExVat()
    {
    }

    public function getPendingOrdersExVat()
    {
    }

    public function numberOfOrdersToday()
    {
    }

    public function getSalesToday()
    {
    }

    public function getOrders()
    {
        $start_date = "2018-07-25";
        $end_date = "2018-07-27";

        $orders = Order::where("shopify_created_at", ">=", $start_date)
        ->where("shopify_created_at", "<=", $end_date)
        ->where("financial_status", "paid")
        ->get()[0];
        return $orders;
    }
}
