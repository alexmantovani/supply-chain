<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OrderPartial extends Component
{
    public $order;
    public $warehouse;
    public $selected;

    public function render()
    {
        return view('livewire.order-partial');
    }

    public function store()
    {
        if (!$this->selected) {
            session()->flash('message', 'Non hai selezionato nessun prodotto.');

            return;
        }

        foreach ($this->selected as $product_id => $selected) {
            if ($selected) {
                $product = $this->order->products()->firstWhere('product_id', $product_id);
                $product->pivot->update([
                    'received_quantity' => $product->pivot->quantity,
                ]);

                $refill = $this->order->refills()->firstWhere('product_id', $product_id);
                $refill->update([
                    'status' => 'completed',
                ]);

                $this->order->logs()->create([
                    'user_id' => Auth::user()->id,
                    'description' => 'Consegnato: ' . $product->name . ' ' .
                        trans_choice('messages.ordered', $product->pivot->quantity) . ' ' .
                        trans_choice('messages.received', $product->pivot->received_quantity),
                    'type' => 'info',
                ]);
            }
        }

        // Faccio il find() per ricaricare i dati che ho cambiato qui sopra nelle tabelle pivot
        $isCompleted = Order::find($this->order->id)->updateStatus();

        $this->order->logs()->create([
            'user_id' => Auth::user()->id,
            'description' => $isCompleted ? 'Ordine completato' : 'Non tutto il materiale ordinato è stato consegnato',
            'type' => 'info',
        ]);

        return redirect()->to('/warehouse/' . $this->warehouse->id . '/order');
    }
}
