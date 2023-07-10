<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable // implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function refills()
    {
        return $this->hasMany(Refill::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class)
            ->withPivot([
                'warehouse_id',
                'is_active',
                'roles',
            ])->withTimestamps();
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function canBeDeleted()
    {
        // TODO: Gestire altri casi

        // Non posso cancellare me stesso
        if ($this->id == Auth::user()->id) return false;

        return true;
    }

    protected static function booted()
    {
        static::created(function ($user) {
            Profile::create([
                'user_id' => $user->id,
            ]);
        });
    }

    // Attiva la compagnia di cui passo l'id
    function enableCompanyWithId($companyId)
    {
        // Spazzolo tutte le compagnie e attivo SOLO quella selezionata
        foreach ($this->companies as $company) {
            $this->companies()->updateExistingPivot($company->id, [
                'is_active' => ($company->id == $companyId),
            ]);
        }

        // Assegno all'utente i tuoli dovuti
        $this->assignRolesForCompanyWithId($companyId);
    }

    public function getActiveCompanyAttribute()
    {
        $company = $this->companies()->firstWhere('is_active', true);

        // Se non ho una compagnia attiva allora vado io ad assegarne una
        if (!$company) {
            $company = $this->companies()->first();
        }

        return $company;
    }

    // A seconda della compagnia attiva, riporta il "warehouse" attivo
    public function getActiveWarehouseAttribute()
    {
        $warehouse = Warehouse::find($this->activeCompany->pivot->warehouse_id);

        // Se non ho una compagnia attiva allora vado io ad assegarne una
        if (!$warehouse) {
            //TODO: Redirect a creare o scegliere un magazzino
            $company = $this->companies()->firstWhere('company_id', $this->activeCompany->id);
            $warehouse = $company->warehouses->first();
        }

        return $warehouse;
    }

    // Abilita per questo utente il warehouse passatomi
    function enableWarehouse(Warehouse $warehouse)
    {
        $this->companies()->updateExistingPivot($warehouse->company_id, [
            'warehouse_id' => $warehouse->id,
        ]);
    }

    function assignRolesForCompanyWithId($companyId)
    {
        $roles = array_filter(explode(',', $this->companies()->firstWhere('company_id', $companyId)->pivot->roles));
        // dd($this->companies()->firstWhere('company_id', $company->id)->pivot->roles);

        // Tolgo tutti i ruoli all'utente
        $this->roles()->detach();

        // Gli do solo quelli a cui è abilitato
        $this->assignRole($roles);
    }
}
