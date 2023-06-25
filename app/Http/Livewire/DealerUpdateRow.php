<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DealerUpdateRow extends Component
{
    public $dealer;
    public $providers;
    public $providerId;

    public function mount()
    {
        $this->providerId = $this->dealer->provider->id;
    }

    public function render()
    {
        return view('livewire.dealer-update-row');
    }

    public function updatedProviderId()
    {
        $this->dealer->update([
            'provider_id' => $this->providerId,
        ]);
    }

}
