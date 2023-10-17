<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\ProcessProduct;
use App\Models\Product;
use App\Models\Dealer;
use App\Models\ProductStatus;
use App\Models\Provider;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Request;

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

        $products = Product::join('dealers', 'dealers.id', 'dealer_id')
            ->select('products.*', 'dealers.name as dealer_name')
            ->where(function ($q) use ($search) {
                // Cerco innanzitutto per singola parola
                $parole_chiave = array_filter(explode(' ', $search));
                foreach ($parole_chiave as $parola) {
                    $q->where('products.name', 'like', '%' . $parola . '%');
                }
                return $q
                    ->orWhere('products.name', 'like', '%' . $search . '%')
                    ->orWhere('dealers.name', 'like', '%' . $search . '%')
                    ->orWhere('uuid', 'like', $search . '%');
            })
            ->whereIn('status_id', $filter_list)
            ->paginate(100);

        return view('product.index', compact('warehouse', 'search', 'products', 'filters'));
    }

    public function admin()
    {
        $warehouse = Warehouse::find($_COOKIE['warehouse_id']);

        $search = Request()->search ?? '';
        $filters = Request()->filters ?? ['Ordinabili'];

        // Innanzi tutto se la parola da cercare è di 10 caratteri, do un'occhiata anche ad DB di Altena prima di mostrare i risultati
        if (strlen($search) >= 10) {
            // Chiedo al DB di Altena se esiste un utente con questo uuid
            ProcessProduct::dispatchSync($search);
        }

        $filter_list = ProductStatus::whereIn('group', $filters)->pluck('id');

        $products = Product::join('dealers', 'dealers.id', 'dealer_id')
            ->select('products.*', 'dealers.name as dealer_name')
            ->where(function ($q) use ($search) {
                // Cerco innanzitutto per singola parola
                $parole_chiave = array_filter(explode(' ', $search));
                foreach ($parole_chiave as $parola) {
                    $q->where('products.name', 'like', '%' . $parola . '%');
                }
                return $q
                    ->orWhere('products.name', 'like', '%' . $search . '%')
                    ->orWhere('dealers.name', 'like', '%' . $search . '%')
                    ->orWhere('uuid', 'like', $search . '%');
            })
            ->whereIn('status_id', $filter_list)
            ->orderBy('provider_id')
            ->paginate(50);

        $hasCriticals = Product::withMissingInfo()->count();

        $providers = Provider::all();

        return view('admin.products', compact('warehouse', 'search', 'products', 'filters', 'providers', 'hasCriticals'));
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
        $ordersTrend = $product->getOrdersByYear(10);
        return view('product.show', compact('warehouse', 'product', 'ordersTrend'));
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

    /**
     * Apre la videata per inserire.
     */
    public function discover()
    {
        $uuid = Request()->uuid;
        Log::info('Richiesto inserimento di un nuovo articolo: ' . $uuid);

        $product = Product::firstWhere('uuid', $uuid);
        if ($product) {
            Log::info('Articolo ' . $uuid . ' già presente in archivio');
        } else {
            // TODO: Lo cerco sul DB di Altena

            // Se esite da Altena lo aggiungo
            $product = Product::firstOrCreate([
                'uuid' => $uuid,
                'name' => 'Nuovo articolo',
                'description' => 'Descrizione del nuovo articolo',
                'dealer_id' => 1,
                'status_id' => 1,
            ]);

            Log::info('Aggiunto nuovo articolo: ' . $uuid . ' - ' . $product->name);
        }

        return true;
    }
}
