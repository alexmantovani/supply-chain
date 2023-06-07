<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRefillRequest;
use App\Http\Requests\UpdateRefillRequest;
use App\Models\Refill;
use App\Models\Product;
use App\Models\Stock;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warehouse;

class RefillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Warehouse $warehouse)
    {
        $refills = $warehouse->refills()
            ->whereIn('status', ['low', 'urgent'])
            ->join('products', 'products.id', '=', 'refills.product_id')
            ->join('dealers', 'dealers.id', '=', 'dealer_id')
            ->join('providers', 'providers.id', '=', 'dealers.provider_id')
            ->select('refills.*', 'products.dealer_id', 'dealers.name', 'providers.id as provider_id')
            ->orderBy('provider_id')
            ->get();
        // dd($refills);
        return view('refill.index', compact(['refills', 'warehouse']));
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
    public function store(StoreRefillRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Refill $refill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Refill $refill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRefillRequest $request, Refill $refill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Refill $refill)
    {
        //
    }

    public function ask(Request $request, Warehouse $warehouse)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = Product::find($productId);

        if ($product->isLow($warehouse)) return abort(403, 'Questo articolo è già in ordine');

        Refill::create([
            'warehouse_id' => $warehouse->id,
            'user_id' => Auth::user()->id,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        return redirect(route("refill.done"));
    }

    public function askRefill(Warehouse $warehouse, $code)
    {
        // TODO: Capire cosa riporta il barcode
        $product = Product::firstWhere('uuid', $code);
        // Non ho trovato il prodotto nel DB
        if (!$product) {
            // TODO: Lo creo chiedendo al DB di Altena
            $product = Product::create([
                'uuid' => $code,
                'name' => 'Prodotto ' . $code,
                'dealer_id' => 1,
                'refill_quantity' => 0,
            ]);
        }
        $present = $warehouse->refills()
            ->where('product_id', $product->id)
            ->whereIn('status', ['low', 'urgent'])
            ->first();
        if ($present) abort(429); // TODO: Dare un errore più comprensibile tipo refill.ignore

        $warehouse->refills()->create([
            'user_id' => 1,
            'warehouse_id' => $warehouse->id,
            'product_id' => $product->id,
            'quantity' => $product->refill_quantity,
        ]);

        return redirect(route("refill.done", compact('warehouse')));
    }

    public function generateTestCode(Warehouse $warehouse)
    {
        $stock_id = rand(1, 10);
        $product = Stock::find($stock_id)->product;

        return view('refill.qrcode', compact('product', 'warehouse'));
    }

    public function requestDone()
    {
        return view('refill.done');
    }
}
