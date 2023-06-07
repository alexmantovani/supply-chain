<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Dealer;
use App\Models\Warehouse;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Warehouse $warehouse)
    {
        $search = Request()->search ?? '';

        $products = Product::where('name', 'like', '%' . $search . '%')
            // ->orWhere('dealer', 'like', '%' . $search . '%')
            ->orderBy('name')->paginate(20);
        return view('product.index', compact('warehouse', 'search', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Dealer $dealer)
    {
        //
        return view('product.create', compact('dealer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create([
            'name' => $request->name,
            "description" => $request->description,
            // "note" => $request->note,
            'dealer_id' => $request->dealer_id,
            'uuid' => Str::uuid(),
        ]);

        return to_route('dealer.show', $request->dealer_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse, Product $product)
    {
        return view('product.show', compact('warehouse', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
