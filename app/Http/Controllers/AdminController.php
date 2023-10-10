<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use PDF;

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

    public function printLabels(Request $request)
    {
        // $products = Product::whereIn('id', $request['product_ids'])->get();
        $products = Product::whereIn('id', [1,2,3,4,5,6])->get();

        // $pdf = PDF::loadView('admin.print-labels', compact('products'));
        // return $pdf->download('documento.pdf');

        // $warehouse = Warehouse::find($_COOKIE['warehouse_id']);
        return view('admin.print-labels', compact('products'));
    }
}
