<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProductUpdateRow extends Component
{
    public $product;
    public $providers;
    public $providerId;
    public $warehouse;

    public function mount()
    {
        $this->providerId = $this->product->provider->id ?? 0;
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
}
