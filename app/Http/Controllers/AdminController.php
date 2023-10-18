<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $warehouse = Auth::user()->warehouse;

        return view('admin.welcome', compact('orders', 'graphOrders', 'warehouse'));
    }

    public function printLabels(Request $request)
    {
        if (isset($request['print'])) {
            $product_ids = explode(',', $request->print);
        } else {
            if (!isset($request['product_ids'])) {
                return redirect()->back()->with('alert', 'Nessun articolo è stato selezionato.');
            }

            $product_ids = $request['product_ids'];
        }
        $products = Product::whereIn('id', $product_ids)->get();

        return view('admin.print-labels', compact('products'));
    }
}
