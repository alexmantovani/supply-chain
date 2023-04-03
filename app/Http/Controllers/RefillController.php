<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRefillRequest;
use App\Http\Requests\UpdateRefillRequest;
use App\Models\Refill;
use App\Models\Product;
use App\Models\Stock;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Auth;

class RefillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $refills = Refill::where('status', 'low')
            ->join('products', 'products.id', '=', 'refills.product_id')
            ->join('dealers', 'dealers.id', '=', 'dealer_id')
            ->select('refills.*', 'products.dealer_id', 'dealers.name')
            ->orderBy('dealer_id')
            ->get();
        // dd($refills);
        return view('refill.index', compact(['refills']));
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

    public function ask(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = Product::find($productId);

        if ($product->isLow()) return abort(403);

        Refill::create([
            'user_id' => Auth::user()->id,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        return redirect(route("refill.done"));
    }

    public function generateTextCode()
    {
        $stock_id = rand(1,10);
        $product = Stock::find($stock_id)->product;

        return view('refill.qrcode', compact('product'));
    }

    public function requestDone()
    {
        return view('refill.done');
    }
}
