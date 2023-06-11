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
        $query = ($show==='all') ? ['aborted', 'waiting', 'pending', 'completed'] : ['waiting'];

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
        foreach ($request->all() as $key => $refill_ids) {
            if (!str_starts_with($key, 'refill')) continue;

            $providerId = explode("_", $key)[1];
            $order = Order::create([
                'provider_id' => $providerId,
                'warehouse_id' => $warehouse->id,
                'uuid' => Order::uuid(),
            ]);

            $products = [];

            foreach ($refill_ids as $refill_id) {
                $quantity = $request->quantity[$refill_id];
                if ($quantity == 0) {
                    Log::error("Ordinato prodotto con quantità =0 refill_id=" . $refill_id);
                    continue;
                }

                $refill = Refill::find($refill_id);

                // Verifico se non è impostata per questo prodotto la quantità di refill automatica
                // ed eventualmente la vado ad impostare
                if (!$refill->product->refill_quantity) {
                    $refill->product->update([
                        'refill_quantity' => $quantity,
                    ]);
                }

                $products[$refill->product_id] = ['quantity' => $quantity];
                // Log::debug("Refill " . $refill . '  prod_id:' . $refill->product_id);

                // Segno questi prodotti come ordinati
                $refill->update([
                    'status' => 'ordered',
                    'order_id' => $order->id,
                ]);
            }

            $order->products()->sync($products);

            // Mail::to($order->provider->email)->send(new OrderSubmit($order));
            SendNewOrderEmailJob::dispatch($order);

            $order->logs()->create([
                'user_id' => Auth::user()->id,
                'description' => 'Emesso ordine',
                'type' => 'info',
            ]);
        }

        return redirect()->back()->with('message_success', 'Prodotti ordinati');
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
    public function edit(Order $order)
    {
        //
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

        // foreach ($order->products as $product) {
        // if ($product->stock) {
        //     $product->stock->increment('quantity', $product->pivot->quantity);
        // } else {
        //     dd($product);
        // }
        // }

        foreach ($order->refills as $refill) {
            $refill->update([
                'status' => 'completed',
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
