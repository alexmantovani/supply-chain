<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
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
        # TODO: Gestire

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
}
