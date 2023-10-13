<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProductUpdateRow extends Component
{
    public $product;
    public $providers;
    public $providerId;
    public $refillQuantity;
    public $warehouse;

    public function mount()
    {
        $this->providerId = $this->product->provider->id ?? 0;
        $this->refillQuantity = $this->product->refill_quantity;
    }

    public function render()
    {
        return view('livewire.product-update-row');
    }

    public function updatedProviderId()
    {
        // Se non ho selezionato nulla non salvo
        if ($this->providerId == 0) return;

        $this->product->update([
            'provider_id' => $this->providerId,
        ]);
    }

    public function updatedRefillQuantity()
    {
        $this->product->update([
            'refill_quantity' => $this->refillQuantity,
        ]);
    }

}
