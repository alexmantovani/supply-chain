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
use App\Jobs\SendAbortOrderEmailJob;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Warehouse $warehouse)
    {
        $show = Request()->show ?? 'pending';

        $query = ($show === 'all') ? ['aborted', 'waiting', 'pending', 'completed', 'closed'] : ['waiting', 'pending'];

        // $statusCounters = ['aborted' => 0, 'waiting' => 0, 'pending' => 0, 'completed' => 0, 'closed' => 0];
        $statusCounters = ['aborted' => 0, 'waiting' => 0, 'closed' => 0, 'completed' => 0];
        $ordersByStatus = $warehouse->orders()
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        foreach ($ordersByStatus as $order) {
            $status = $order->status;
            if ($status=='pending') $status = 'waiting';

            $statusCounters[$status] += $order->count;
        }

        $orders = $warehouse->orders()
            ->whereIn('status', $query)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('order.index', compact('warehouse', 'orders', 'show', 'statusCounters'));
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
     * Mostra il form per completare l'ordine inserendo i dati mancanti (quantità, fornitore).
     */
    public function complete(Warehouse $warehouse, Order $order)
    {
        return view('order.complete', compact('order', 'warehouse'));
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

    public function closed(Order $order)
    {
        $order->update([
            'status' => 'closed',
        ]);

        $order->refills()->whereIn('status', ['low', 'urgent', 'ordered'])
            ->update([
                'status' => 'aborted',
            ]);

        $order->logs()->create([
            'user_id' => Auth::user()->id,
            'description' => 'Ordine chiuso con materiale mancante',
            'type' => 'info',
        ]);

        return redirect()->back();
    }
}
