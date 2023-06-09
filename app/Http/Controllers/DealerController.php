<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDealerRequest;
use App\Http\Requests\UpdateDealerRequest;
use App\Models\Dealer;
use App\Models\Warehouse;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $filters = Request()->filters ?? ['available'];

        $products = $dealer->products()
            ->where(function ($q) use ($search) {
                return $q
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('uuid', 'like', $search . '%');
            })
            ->whereIn('status', $filters)
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
