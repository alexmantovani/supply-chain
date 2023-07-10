<?php

namespace App\Http\Livewire;

use App\Models\Warehouse;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserUpdateRow extends Component
{
    public $user;
    public $roles;
    public $warehouseId;
    public $company;
    public $userRoles;
    public $warehouses;
    public $hideRow = false;

    // protected $rules = [
    //     'userRoles' => 'required',
    // ];

    public function mount()
    {
        $this->warehouseId = $this->user->activeWarehouse->id;
        // $this->userRoles = $this->user->roles->pluck('name');
        $this->userRoles = array_filter(explode(',', $this->user->companies->first()->pivot->roles));
    }

    public function render()
    {
        return view('livewire.user-update-row');
    }

    public function updatedWarehouseId()
    {
        $this->user->companies()->updateExistingPivot($this->company->id, [
            'warehouse_id' => $this->warehouseId
        ]);
    }

    public function updatedUserRoles()
    {
        $this->user->companies()->updateExistingPivot($this->company->id, [
            'roles' => implode(",", $this->userRoles)
        ]);

        // $this->user->syncRoles($this->userRoles);
    }

    function deleteUser() {
        $this->user->delete();

        $this->hideRow = true;
    }
}
