<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Refill;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $orders = Order::all()->sortBy('created_at', true);
        $query = Request()->has('all') ? ['placed', 'processed'] : ['placed'];
        $orders = Order::whereIn('status', $query)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('order.index', compact('orders'));
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
    public function store(StoreOrderRequest $request)
    {
        // Creo l'ordine con le richieste selezionate
        foreach ($request->all() as $key => $refill_ids) {
            if (!str_starts_with($key, 'dealer')) continue;

            // Ricavo l'id di tutti i prodotti che dovrò mettere nell'ordine
            $product_ids = Refill::whereIn('id', $refill_ids)->pluck('product_id');

            // Creo il nuovo ordine
            $dealerId = explode("_", $key)[1];
            $order = Order::create([
                'dealer_id' => $dealerId,
            ]);

            // Gli assegno i prodotti da acquistare
            // TODO: Aggiungere la quantità
            // $order->products()->sync($product_ids);
            $order->products()->syncWithPivotValues($product_ids, ['quantity' => 5]);

            $order->logs()->create([
                'user_id' => Auth::user()->id,
                'description' => 'Emesso ordine',
                'type' => 'info',
            ]);

            // Segno questi prodotti come ordinati
            Refill::whereIn('id', $refill_ids)
                ->update(['status' => 'ordered']);
        }

        return redirect()->back()->with('message_success', 'Prodotti ordinati');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('order.show', compact('order'));
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
    public function destroy(Order $order)
    {
        //
    }

    public function completed(Order $order)
    {
        $order->update([
            'status' => 'processed',
        ]);

        foreach ($order->products as $product) {
            if ($product->stock) {
                $product->stock->increment('quantity', $product->pivot->quantity);
            } else {
                dd($product);
            }
            foreach ($product->refills as $refill) {
                $refill->update([
                    'status' => 'processed',
                ]);
            }
        }

        $order->logs()->create([
            'user_id' => Auth::user()->id,
            'description' => 'Ordine concluso',
            'type' => 'info',
        ]);

        return redirect()->back();
    }
}
