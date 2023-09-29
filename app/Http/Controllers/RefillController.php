<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRefillRequest;
use App\Http\Requests\UpdateRefillRequest;
use App\Models\Refill;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warehouse;

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
            ->join('products', 'products.id', '=', 'refills.product_id')
            ->join('dealers', 'dealers.id', '=', 'dealer_id')
            ->join('providers', 'providers.id', '=', 'dealers.provider_id')
            ->select('refills.*', 'products.name as product_name', 'products.uuid as product_uuid', 'products.dealer_id', 'dealers.name as dealer_name', 'providers.id as provider_id')
            ->orderBy('provider_id')
            ->get();
        // dd($refills);
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
        dd($refill);
    }

    // public function ask(Request $request, Warehouse $warehouse)
    // {
    //     $productId = $request->input('product_id');
    //     $quantity = $request->input('quantity');
    //     $warehouseId = $request->input('warehouse_id');

    //     $warehouse = Warehouse::find($warehouseId);
    //     $product = Product::find($productId);

    //     if ($product->isLow($warehouse)) {
    //         return abort(403, 'Questo articolo è già in ordine');
    //     }

    //     Refill::create([
    //         'warehouse_id' => $warehouseId,
    //         'user_id' => Auth::user()->id,
    //         'product_id' => $productId,
    //         'quantity' => $quantity,
    //     ]);

    //     return redirect(route("refill.done", compact('warehouse')));
    // }

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

        // Non ho trovato il prodotto nel DB
        if (!$product) {
            // TODO: Non lo devo creare ma devo chiedere ad Altena se esiste
            // $product = Product::create([
            //     'uuid' => $code,
            //     'status_id' => 1,
            // ]);

            // Chiedo al DB di Altena le info sul prodotto
            ProcessProduct::dispatch($product);

            return 4; // Non trovato
        }
        if (!$product->isOrdinable()) return 3;

        $present = $warehouse->refills()
            ->where('product_id', $product->id)
            ->whereIn('status', ['low', 'urgent', 'ordered'])
            ->first();
        if ($present) {
            if ($present->status == 'ordered') return 2;

            return 1;
        }
        $warehouse->refills()->create([
            'user_id' => 1,
            'warehouse_id' => $warehouse->id,
            'product_id' => $product->id,
            'quantity' => $quantity ?? $product->refillQuantity($warehouse->id),
        ]);

        return 0; // Done

    }
}
