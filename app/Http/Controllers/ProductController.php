<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Dealer;
use App\Models\ProductStatus;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Warehouse $warehouse)
    {
        $search = Request()->search ?? '';
        $filters = Request()->filters ?? ['Ordinabili'];

        $filter_list = ProductStatus::whereIn('group', $filters)->pluck('id');

        $products = Auth::user()->activeCompany->products()->join('dealers', 'dealers.id', 'dealer_id')
            ->select('products.*', 'dealers.name as dealer_name')
            ->where(function ($q) use ($search) {
                return $q
                    ->where('products.name', 'like', '%' . $search . '%')
                    ->orWhere('dealers.name', 'like', '%' . $search . '%')
                    ->orWhere('uuid', 'like', $search . '%');
            })
            ->whereIn('status_id', $filter_list)
            ->paginate(100);

        return view('product.index', compact('warehouse', 'search', 'products', 'filters'));
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
        $warehouses = $warehouse->company->warehouses;
        return view('product.show', compact('warehouse', 'product', 'warehouses'));
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

    public function showImportPage(Dealer $dealer)
    {
        return view('product.import', compact('dealer'));
    }

    public function import(Request $request, Dealer $dealer)
    {
        $request->validate([
            'file_csv' => 'required',
        ]);

        $company = Auth::user()->active_company;
        $pathFile = $request->file_csv->getPathname();

        if (($handle = fopen($pathFile, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $code = $data[0];
                if ($code == 'Articolo') continue;
                if (strlen($code) == 0) continue;

                Product::updateOrCreate([
                    'company_id' => $company->id,
                    'uuid' => $data[0],
                ], [
                    'dealer_id' => $dealer->id,
                    'status_id' => 1, // OK
                    'name' => $data[1],
                ]);
            }
            fclose($handle);
        }
    }
}
