<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RefillQuantity extends Component
{
    public $warehouse;
    public $refill;
    public $quantity;
    public $hideRow;

    public function render()
    {
        return view('livewire.refill-quantity');
    }

    public function mount()
    {
        $this->quantity = $this->refill->quantity;
        $this->hideRow = false;
    }

    public function updateQuantity()
    {
        if ( $this->quantity ) {
            $this->refill->update([
                'quantity' => $this->quantity,
            ]);

            $this->hideRow = true;
        }
    }
}
