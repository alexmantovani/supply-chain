<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDealerRequest;
use App\Http\Requests\UpdateDealerRequest;
use App\Models\Dealer;
use App\Models\ProductStatus;
use App\Models\Warehouse;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dealers = Dealer::all()->sortBy('name');
        $providers = Provider::all();

        $warehouse = Auth::user()->warehouse;

        return view('dealer.index', compact('dealers', 'providers', 'warehouse'));
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
    public function store(StoreDealerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse, Dealer $dealer)
    {
        $search = Request()->search ?? '';
        $filters = Request()->filters ?? ['Ordinabili'];

        $filter_list = ProductStatus::whereIn('group', $filters)->pluck('id');

        $products = $dealer->products()
            ->where(function ($q) use ($search) {
                return $q
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('uuid', 'like', $search . '%');
            })
            ->whereIn('status_id', $filter_list)
            ->paginate(100);
            return view('dealer.show', compact('warehouse', 'dealer', 'products', 'search', 'filters'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dealer $dealer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDealerRequest $request, Dealer $dealer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dealer $dealer)
    {
        //
    }
}
