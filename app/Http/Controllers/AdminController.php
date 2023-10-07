<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $graphOrders = Order::getOrdersDoneByYear();

        $orders = Order::whereIn('status', ['completed', 'closed'])
            ->join('warehouses', 'orders.warehouse_id', '=', 'warehouses.id')
            ->groupBy('warehouse_id')
            ->selectRaw('*, COUNT(*) as in_progress, warehouses.name as warehouse_name')
            ->get();

        $warehouse = Warehouse::find($_COOKIE['warehouse_id']);

        return view('admin.welcome', compact('orders', 'graphOrders', 'warehouse'));
    }
}
