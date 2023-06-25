<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserUpdateRow extends Component
{
    public $user;
    public $roles;
    public $warehouseId;
    public $userRoles;

    protected $rules = [
        'userRoles' => 'required',
    ];

    public function mount()
    {
        $this->warehouseId = $this->user->profile->warehouse_id;
        $this->userRoles = $this->user->roles->pluck('name');
    }

    public function render()
    {
        return view('livewire.user-update-row');
    }

    public function updatedWarehouseId()
    {
        $this->user->profile->update([
            'warehouse_id' => $this->warehouseId,
        ]);
    }

    public function updatedUserRoles()
    {
        $this->user->syncRoles($this->userRoles);
    }
}
