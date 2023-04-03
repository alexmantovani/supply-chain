<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Refill;
use App\Models\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::all();
        return view('stock.index', compact(['stocks']));
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
    public function store(StoreStockRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }


    public function pickup(Stock $stock)
    {
        $stock->decrement('quantity', 1);

        // Nel caso il materiale stia finendo lo vado a mettere tra quelli in esaurimento
        if ($stock->status == 'Basso') {
            if ( ! $stock->product->isLow() ) {
                Refill::create([
                    'product_id' => $stock->product->id,
                    'quantity' => 5,
                ]);
            }
        }

        return redirect()->back()->with('message_success', 'Materiale prelevato con successo.');
    }
}
