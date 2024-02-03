<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ProductUpdateRow extends Component
{
    public $product;
    public $providers;
    public $providerId;
    public $refillQuantity;
    public $warehouse;
    public $package;
    public $unitOfMeasure;

    public function mount()
    {
        $this->providerId = $this->product->providerId($this->warehouse->id);
        $this->refillQuantity = $this->product->refillQuantity($this->warehouse->id);
        $this->package = $this->product->pieces_in_package;
        $this->unitOfMeasure = $this->product->unit_of_measure;
    }

    public function render()
    {
        return view('livewire.product-update-row');
    }

    public function updatedProviderId()
    {
        // Se ho selezionato un fornitore, allora salvo il valore
        // Qualsiasi esso sia e mi dimentico di usare i default presenti nel provider
        $this->product->warehouses()->syncWithoutDetaching([
            $this->warehouse->id => ['provider_id' => $this->providerId]
        ]);
    }

    public function updatedRefillQuantity()
    {
        // Se ho selezionato una quantità, allora salvo il valore
        // Qualsiasi esso sia e mi dimentico di usare i default presenti nel provider
        if ((is_numeric($this->refillQuantity)) || ($this->refillQuantity == '')) {
            $this->product->warehouses()->syncWithoutDetaching([
                $this->warehouse->id => ['refill_quantity' => $this->refillQuantity]
            ]);
        }
    }

    public function updatedUnitOfMeasure()
    {
        $this->product->update([
            'unit_of_measure' => $this->unitOfMeasure,
        ]);
    }

    public function updatedPackage()
    {
        if ((is_numeric($this->package)) || ($this->package == '')) {
            $this->product->update([
                'pieces_in_package' => $this->package,
            ]);
        }
    }
}
