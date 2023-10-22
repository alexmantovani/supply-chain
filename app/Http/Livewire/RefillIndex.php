<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\Refill;
use App\Jobs\SendNewOrderEmailJob;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RefillIndex extends Component
{
    public $warehouse;
    public $refills;
    public $deleteId = 0;

    public $quantity = [];
    public $selected = [];

    public function mount()
    {
        foreach ($this->refills as $refill) {
            $this->quantity[$refill->id] = $refill->quantity;
            $this->selected[$refill->id] = true; // Di default li seleziono tutti (anche quelli senza quantità)
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
        // Raggruppo il materiale mancante in base al fornitore
        $grouped = $this->refills->groupBy('provider_id');

        // Spazzolo i refills in base ai fornitori
        foreach ($grouped as $providerId => $refills) {
            $products = [];
            $order = null;

            foreach ($refills as $refill) {
                $selected = $this->selected[$refill->id];
                if ($selected) {
                    $quantity = $this->quantity[$refill->id];

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
                }
            }

            // Se è stato generato un ordine allora aggiungo i prodotti e lo invio
            if ($order) {
                $order->products()->sync($products);

                $order->logs()->create([
                    'user_id' => Auth::user()->id,
                    'description' => 'Creato da ' . $this->warehouse->name . ' ordine di richiesta materiale a ' . $order->provider_name,
                    'type' => 'info',
                ]);

                SendNewOrderEmailJob::dispatch($order, true); // true perchè la mail viene segnata come urgente
            }
        }

        return redirect()->to('/warehouse/' . $this->warehouse->id . '/refill');
    }
}
