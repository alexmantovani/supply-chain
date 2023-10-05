<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $graphOrders = Order::getOrdersDoneByYear();

        $orders = Order::whereIn('status', ['waiting', 'pending'])
            ->join('warehouses', 'orders.warehouse_id', '=', 'warehouses.id')
            ->groupBy('warehouse_id')
            ->selectRaw('*, COUNT(*) as in_progress, warehouses.name as warehouse_name')
            ->get();

        // dd($orders);
        return view('admin.welcome', compact('orders', 'graphOrders'));
    }
}
