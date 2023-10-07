<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DealerUpdateRow extends Component
{
    public $dealer;
    public $providers;
    public $providerId;
    public $warehouse;

    public function mount()
    {
        $this->providerId = $this->dealer->provider->id ?? 0;
    }

    public function render()
    {
        return view('livewire.dealer-update-row');
    }

    public function updatedProviderId()
    {
        // Se non ho selezionato nulla non salvo
        if ($this->providerId == 0) return;

        $this->dealer->update([
            'provider_id' => $this->providerId,
        ]);
    }
}
