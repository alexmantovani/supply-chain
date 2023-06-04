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
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Warehouse $warehouse)
    {
        // $orders = Order::all()->sortBy('created_at', true);
        $query = Request()->has('all') ? ['aborted', 'waiting', 'pending', 'completed'] : ['waiting'];
        $orders = $warehouse->orders()
            ->whereIn('status', $query)
            ->orderBy('created_at', 'desc')
            ->paginate(100);
        return view('order.index', compact('warehouse', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function uuid($length=12)
    {
        $unique = Str::random($length);
        $check = Order::where('uuid', $unique)->first();
        if ($check) {
            return $this->uuid();
        }

        return $unique;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, Warehouse $warehouse)
    {
        // Creo l'ordine con le richieste selezionate
        foreach ($request->all() as $key => $refill_ids) {
            if (!str_starts_with($key, 'dealer')) continue;

            // Ricavo l'id di tutti i prodotti che dovrò mettere nell'ordine
            // $product_ids = Refill::whereIn('id', $refill_ids)->pluck('product_id');

            $dealerId = explode("_", $key)[1];

            // Per ogni prodotto genero un ordine (prima erano legati a un ordine con più prodotti per un fornitore)
            foreach ($refill_ids as $refill_id) {
                $refill = Refill::find($refill_id);

                // Creo il nuovo ordine
                $quantity = $request['quantity_' . $refill->id];

                // Se di quel prodotto non devo prenderne nessuno allora lo lascio li
                if ( $quantity==0 ) {
                    continue;
                }

                $order = Order::create([
                    'dealer_id' => $dealerId,
                    'warehouse_id' => $warehouse->id,
                    'uuid' => $this->uuid(),
                ]);

                // Gli assegno il singolo prodotto da acquistare
                $order->products()->syncWithPivotValues($refill->product_id, ['quantity' => $quantity]);

                Mail::to('a@a.a')->send(new OrderSubmit($order));

                $order->logs()->create([
                    'user_id' => Auth::user()->id,
                    'description' => 'Emesso ordine',
                    'type' => 'info',
                ]);

                // Segno questi prodotti come ordinati
                $refill->update(['status' => 'ordered']);
            }
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
    public function destroy(Order $order)
    {
        //
    }

    public function completed(Order $order)
    {
        $order->update([
            'status' => 'completed',
        ]);

        foreach ($order->products as $product) {
            if ($product->stock) {
                $product->stock->increment('quantity', $product->pivot->quantity);
            } else {
                dd($product);
            }
            foreach ($product->refills as $refill) {
                $refill->update([
                    'status' => 'completed',
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
