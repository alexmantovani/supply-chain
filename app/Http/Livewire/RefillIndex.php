<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\Refill;
use App\Jobs\SendNewOrderEmailJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RefillIndex extends Component
{
    public $warehouse;
    public $refills;
    public $deleteId = 0;

    public $quantity = [];
    public $selected = [];
    // public $submitButtonEnabled = false;

    public function mount()
    {
        foreach ($this->refills as $refill) {
            $this->quantity[$refill->id] = $refill->quantity;
            $this->selected[$refill->id] = ($refill->quantity > 0);
            // array_push($this->quantity, [$refill->id => 7] );
            // $this->updateQuantity($refill->id, (bool)($refill->quantity > 0));
        }
    }

    public function render()
    {
        return view('livewire.refill-index');
    }

    protected $rules = [
        'refills.*.quantity' => 'required|numeric',
    ];

    public function hydrate()
    {
        $this->refills = $this->warehouse->refills()
            ->whereIn('refills.status', ['low', 'urgent'])
            ->join('products', 'products.id', '=', 'refills.product_id')
            ->join('dealers', 'dealers.id', '=', 'dealer_id')
            ->join('providers', 'providers.id', '=', 'dealers.provider_id')
            ->select('refills.*', 'products.name as product_name', 'products.uuid as product_uuid', 'products.dealer_id', 'dealers.name as dealer_name', 'providers.id as provider_id')
            ->orderBy('provider_id')
            ->get();
    }

    public function delete($id)
    {
        $refill = Refill::find($id);
        $refill->delete();

        unset($this->selected[$id]);

        $this->hydrate();
    }

    public function sendOrder()
    {
        $grouped = $this->refills->groupBy('provider_id');

        // Spazzolo i refills in base ai fornitori
        foreach ($grouped as $providerId => $refills) {
            $products = [];
            $order = null;

            foreach ($refills as $refill) {
                $selected = $this->selected[$refill->id];
                if ($selected) {
                    if ($this->quantity[$refill->id] > 0) {
                        $quantity = $this->quantity[$refill->id];

                        // Verifico se non è impostata per questo prodotto la quantità di refill automatica
                        // ed eventualmente la vado ad impostare
                        if (!$refill->product->refill_quantity) {
                            $refill->product->update([
                                'refill_quantity' => $quantity,
                            ]);
                        }

                        $products[$refill->product_id] = ['quantity' => $quantity];

                        if ($order == null) {
                            $order = Order::create([
                                'provider_id' => $providerId,
                                'warehouse_id' => $this->warehouse->id,
                                'uuid' => Order::uuid(),
                            ]);
                        }

                        // Segno questi prodotti come ordinati
                        $refill->update([
                            'status' => 'ordered',
                            'order_id' => $order->id,
                        ]);
                    } else {
                        Log::warning("Selezionato prodotto con quantità =0 " .$refill->product->name );
                    }
                }
            }

            // Se è stato generato un ordine allora lo invio
            if ($order) {
                $order->products()->sync($products);

                SendNewOrderEmailJob::dispatch($order);

                $order->logs()->create([
                    'user_id' => Auth::user()->id,
                    'description' => 'Emesso ordine',
                    'type' => 'info',
                ]);
            }
        }

        return redirect()->to('/warehouse/' . $this->warehouse->id . '/refill');
    }
}
