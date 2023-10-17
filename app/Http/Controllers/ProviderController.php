<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\UpdateProviderRequest;
use App\Models\Provider;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::all();

        $warehouse = Auth::user()->warehouse;

        return view('provider.index', compact('providers', 'warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('provider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProviderRequest $request)
    {
        $provider = Provider::create([
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'provider_code' => $request->provider_code,
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::random(30);
            $file->move(public_path('provider_images'), $filename);
            $provider->update([
                'image_url' => $filename,
            ]);
        }

        return to_route('provider.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        $warehouse = Auth::user()->warehouse;

        $products = $provider->products()->paginate(100);

        return view('provider.show', compact('provider', 'warehouse', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        return view('provider.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProviderRequest $request, Provider $provider)
    {
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::random(30);
            $file->move(public_path('provider_images'), $filename);
            $provider->update([
                'image_url' => $filename,
            ]);
        }

        $provider->update([
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'provider_code' => $request->provider_code,
        ]);

        return to_route('provider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();

        return to_route('provider.index');
    }
}
