<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Refill;
use App\Models\Warehouse;
use Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSubmit;
use App\Models\Product;
use Log;
use App\Jobs\SendNewOrderEmailJob;
use App\Jobs\SendAbortOrderEmailJob;
use GuzzleHttp\Psr7\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Warehouse $warehouse)
    {
        $show = Request()->show ?? 'pending';

        // $query = Request()->has('all') ? ['aborted', 'waiting', 'pending', 'completed'] : ['waiting'];
        $query = ($show==='all') ? ['aborted', 'waiting', 'pending', 'completed'] : ['waiting', 'pending'];

        $orders = $warehouse->orders()
            ->whereIn('status', $query)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('order.index', compact('warehouse', 'orders', 'show'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, Warehouse $warehouse)
    {
    }


    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse, Order $order)
    {
        return view('order.show', compact('order', 'warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse, Order $order)
    {
        return view('order.edit', compact('order', 'warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse, Order $order)
    {
        $order->update([
            'status' => 'aborted',
        ]);

        foreach ($order->refills as $refill) {
            $refill->update([
                'status' => 'aborted',
            ]);
        }

        $order->logs()->create([
            'user_id' => Auth::user()->id,
            'description' => 'Ordine annullato',
            'type' => 'info',
        ]);

        // Se l'ordine era già stato fatto occorrerà inviare mail per segnalare l'annullamento
        SendAbortOrderEmailJob::dispatch($order);

        return redirect()->back();
    }

    public function completed(Order $order)
    {
        $order->update([
            'status' => 'completed',
        ]);

        foreach ($order->refills as $refill) {
            $refill->update([
                'status' => 'completed',
            ]);
        }

        // Segno tutti i prodotti all'interno dell'ordine come arrivati
        foreach ($order->products as $product) {
            $product->pivot->update([
                'received_quantity' => $product->pivot->quantity,
            ]);
        }

        $order->logs()->create([
            'user_id' => Auth::user()->id,
            'description' => 'Ordine completato',
            'type' => 'info',
        ]);

        return redirect()->back();
    }
}
