<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRefillRequest;
use App\Http\Requests\UpdateRefillRequest;
use App\Models\Refill;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Log;

use App\Jobs\ProcessProduct;

class RefillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Warehouse $warehouse)
    {
        $refills = $warehouse->refills()
            ->whereIn('refills.status', ['low', 'urgent'])
            ->get();

        return view('refill.index', compact(['refills', 'warehouse']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Warehouse $warehouse)
    {
        return view('refill.create', compact('warehouse'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Warehouse $warehouse, StoreRefillRequest $request)
    {
        $codes = explode(" ", $request['codes']);
        $quantity = $request['quantity'] ?? null;
        $warehouse_id = $request['warehouse_id'] ?? $warehouse->id;

        $errors = [];
        foreach ($codes as $code) {
            $result = $this->putInList(Warehouse::find($warehouse_id), $code, $quantity);

            switch ($result) {
                case 1:
                    array_push($errors, ['code' => $code, 'error' => 'L\'articolo "' . $code . '" è già presente nella lista dei materiali in esaurimento']);
                    break;
                case 2:
                    array_push($errors, ['code' => $code, 'error' => 'L\'articolo "' . $code . '" è già presente nella lista dei materiali ordinati']);
                    break;
                case 3:
                    array_push($errors, ['code' => $code, 'error' => 'L\'articolo "' . $code . '" non è più ordinabile']);
                    break;
                case 4:
                    array_push($errors, ['code' => $code, 'error' => 'Articolo "' . $code . '" non trovato']);
                    break;
            }
        }

        return view("refill.done", compact('warehouse', 'errors', 'codes'));
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
    public function destroy(Warehouse $warehouse, Refill $refill)
    {
    }

    public function request(Warehouse $warehouse)
    {
        $code = Request()->code;

        $errors = [];

        $result = $this->putInList($warehouse, $code);
        switch ($result) {
            case 1:
                array_push($errors, ['code' => $code, 'error' => 'L\'articolo "' . $code . '" è già presente nella lista dei materiali in esaurimento']);
                break;
            case 2:
                array_push($errors, ['code' => $code, 'error' => 'L\'articolo "' . $code . '" è già presente nella lista dei materiali ordinati']);
                break;
            case 3:
                array_push($errors, ['code' => $code, 'error' => 'L\'articolo "' . $code . '" non è più ordinabile']);
                break;
            case 4:
                array_push($errors, ['code' => $code, 'error' => 'Articolo "' . $code . '" non trovato']);
                break;
        }

        $codes = [$code];
        return view("refill.done", compact('warehouse', 'errors', 'codes'));
    }

    public function generateTestCode(Warehouse $warehouse)
    {
        $product = Product::find(rand(1, 100));

        return view('refill.qrcode', compact('product', 'warehouse'));
    }

    public function requestDone(Warehouse $warehouse, Product $product)
    {
        return view('refill.done', compact('warehouse', 'product'));
    }

    public function requestError(Warehouse $warehouse, Product $product)
    {
        return view('refill.error', compact('warehouse', 'product'))->with('message', 'Errore!!!');
    }

    public function putInList(Warehouse $warehouse, $code, $quantity = null)
    {
        $product = Product::firstWhere('uuid', $code);

        // Non ho trovato il prodotto nel mio DB
        if (!$product) {
            // Chiedo al DB di Altena le info sul prodotto
            // Passo $code perche potrebbe trattarsi di un articolo nuovo di cui non ho ancora nessuna info
            ProcessProduct::dispatchSync($code);

            // Lo torno a cercare nella speranza di averlo trovato nel DB di Altena
            $product = Product::firstWhere('uuid', $code);
            if (!$product) {
                Log::error("Prodotto $code non trovato neanche nel DB di Altena");
                return 4; // Non trovato
            }

            Log::debug("Product $code not found in DB, but found in Altena DB");
        }
        if (!$product->isOrdinable()) return 3;

        $present = $warehouse->refills()
            ->where('product_id', $product->id)
            ->whereIn('status', ['low', 'urgent', 'ordered'])
            ->first();
        if ($present) {
            // E' già stato ordinato
            if ($present->status == 'ordered') return 2;

            return 1;
        }

        Refill::create([
            'user_id' => Auth::user()->id,
            'warehouse_id' => $warehouse->id,
            'product_id' => $product->id,
            'provider_id' => $product->providerId($warehouse->id),
            'quantity' => $quantity ?? $product->refillQuantity($warehouse->id),
        ]);

        Log::debug("Aggiunto da $warehouse->name l'articolo $product->uuid alla lista dei materiali da ordinare");

        return 0; // Done

    }
}
