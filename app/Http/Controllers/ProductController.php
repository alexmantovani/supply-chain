<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\ProcessProduct;
use App\Models\Product;
use App\Models\Dealer;
use App\Models\Order;
use App\Models\ProductStatus;
use App\Models\Provider;
use App\Models\Warehouse;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;
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
        $warehouse = Auth::user()->warehouse;

        $search = Request()->search ?? '';
        $filters = Request()->filters ?? ['Ordinabili'];
        $show_criticals = Request()->show_criticals ?? false;

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

        $hasCriticals = $warehouse->productsWithMissingInfo()->count();
        if ($show_criticals && $hasCriticals) {
            $products = $warehouse->productsWithMissingInfo()->paginate(50);
        }

        $providers = Provider::all();

        return view('admin.products', compact('warehouse', 'search', 'products', 'filters', 'providers', 'hasCriticals', 'show_criticals'));
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

        $provider = Provider::find($product->providerId($warehouse->id));
        return view('product.show', compact('warehouse', 'product', 'ordersTrend', 'provider'));
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

    /*
     * Apre la pagina per acquisire il qrcode di un prodotto
    */
    public function checkin(Warehouse $warehouse)
    {
        return view('product.checkin', compact('warehouse'));
    }

    public function delivered(Warehouse $warehouse)
    {
        $codes = explode(" ", Request()['codes']);

        $errors = [];
        foreach ($codes as $code) {
            // Cerco il prodotto in base al suo UUID
            $product = Product::firstWhere('uuid', $code);

            // Non trovo il prodotto inserito
            if (!$product) {
                array_push($errors, ['code' => $code, 'error' => 'L\'articolo "' . $code . '" non è a listino']);

                Log::error('Articolo ' . $code . ' non trovato');
                continue;
            }

            // Ricavo il relativo ordine in base al magazzino in cui mi trovo
            $order = $product->openOrders->firstWhere('warehouse_id', $warehouse->id);

            if ($order) {
                $product = $order->products()->firstWhere('products.id', $product->id);

                // Ricavo la quantità del prodotto in base al relativo ordine
                $quantity = $product->pivot->quantity;

                // Aggiorna la quantità nella tabella pivot "order_product"
                $order->products()->updateExistingPivot($product, ['received_quantity' => $quantity]);

                // Aggiorno anche in refill per far si che questo articolo possa essere riordinato nuovamente
                $refill = $order->refills()->firstWhere('product_id', $product->id);
                $refill->update([
                    'status' => 'completed',
                ]);

                $order->logs()->create([
                    'user_id' => Auth::user()->id,
                    'description' => 'Consegnato: ' . $product->name . ' ' .
                        trans_choice('messages.ordered', $product->pivot->quantity) . ' ' .
                        trans_choice('messages.received', $product->pivot->received_quantity),
                    'type' => 'info',
                ]);

                // Faccio il find() per ricaricare i dati che ho cambiato qui sopra nelle tabelle pivot
                $isCompleted = Order::find($order->id)->updateStatus();
                if ($isCompleted) {
                    $order->logs()->create([
                        'user_id' => Auth::user()->id,
                        'description' => $isCompleted ? 'Ordine completato' : 'Non tutto il materiale ordinato è stato consegnato',
                        'type' => 'info',
                    ]);
                }
            } else {
                // Non trovato
                array_push($errors, ['code' => $code, 'error' => 'L\'articolo "' . $code . '" non è presente in nessun ordine']);

                Log::error('Articolo ' . $code . ' non trovato');
            }
        }

        return view("product.checkin_done", compact('warehouse', 'errors', 'codes'));
    }
}
