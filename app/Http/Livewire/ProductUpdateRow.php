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

    public function mount()
    {
        $this->providerId = $this->product->providerId($this->warehouse->id);
        $this->refillQuantity = $this->product->refillQuantity($this->warehouse->id);
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

        // // Se non ho selezionato nulla non salvo
        // if ($this->providerId == 0) return;

        // // Se nel prodotto non ho il fornitore, allora questo valore lo imposto come default,
        // // le volte successive invece le considero come personalizzazioni e vado ad agire solo sul singolo magazzino
        // if ($this->product->default_provider_id > 0) {
        //     $this->product->warehouses()->syncWithoutDetaching([
        //         $this->warehouse->id => ['provider_id' => $this->providerId]
        //     ]);
        // } else {
        //     $this->product->update([
        //         'default_provider_id' => $this->providerId,
        //     ]);
        // }
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

        // if ((is_numeric($this->refillQuantity)) || ($this->refillQuantity == '')) {

        //     // Se nel prodotto non ho il fornitore, allora questo valore lo imposto come default,
        //     // le volte successive invece le considero come personalizzazioni e vado ad agire solo sul singolo magazzino
        //     if ($this->product->default_refill_quantity >= 0) {
        //         $this->product->warehouses()->syncWithoutDetaching([
        //             $this->warehouse->id => ['refill_quantity' => $this->refillQuantity]
        //         ]);
        //     } else {
        //         // TODO: Testare che con null, cada qui dentro
        //         $this->product->update([
        //             'default_refill_quantity' => $this->refillQuantity,
        //         ]);
        //     }
        // } else {
        //     $this->refillQuantity = $this->product->default_refill_quantity;
        // }
    }
}
