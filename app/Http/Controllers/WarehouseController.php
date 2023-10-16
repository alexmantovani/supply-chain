<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = Warehouse::all();

        return view('warehouse.index', compact('warehouses'));
    }

    public function adminIndex()
    {
        $warehouses = Warehouse::all();

        $warehouse = Warehouse::find($_COOKIE['warehouse_id']);

        return view('admin.warehouses', compact('warehouses', 'warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
        Warehouse::create([
            'name' => $request->name,
            'description' => $request->description,
            'emails' => $request->emails,
        ]);

        $warehouses = Warehouse::all();
        return to_route('admin.warehouses', compact('warehouses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('change warehouse')) {
            if ($warehouse->id != $user->profile->warehouse_id) {
                abort(403);
            }
        }

        $user->profile->update([
            'warehouse_id' => $warehouse->id,
        ]);

        $refills = $warehouse->refills()
            ->whereIn('refills.status', ['low', 'urgent'])
            ->whereNot('quantity', '>', 0)
            // ->whereNull('quantity')
            ->join('products', 'products.id', '=', 'refills.product_id')
            ->join('dealers', 'dealers.id', '=', 'dealer_id')
            ->join('providers', 'providers.id', '=', 'products.provider_id')
            ->select('refills.*', 'products.dealer_id', 'dealers.name', 'providers.id as provider_id')
            ->orderBy('provider_id')
            ->get();

        $orders = $warehouse->orders
            ->whereIn('status', ['waiting', 'pending'])
            ->where('created_at', '<=', now()->subDays(7));

        return view('warehouse.show', compact('warehouse', 'refills', 'orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        return view('warehouse.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        $warehouse->update([
            'name' => $request->name,
            'description' => $request->description,
            'emails' => $request->emails,
        ]);

        $warehouses = Warehouse::all();
        return to_route('admin.warehouses', compact('warehouses'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        $warehouses = Warehouse::all();
        return to_route('admin.warehouses', compact('warehouses'));
    }
}
