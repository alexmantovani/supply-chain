<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function refills()
    {
        return $this->hasMany(Refill::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot([
                'refill_quantity',
                'provider_id',
                'step',
            ])
            ->withTimestamps();
    }

    public function productsWithMissingInfo()
    {
        $presentButIncomplete = $this->products()
            ->where(function ($query) {
                $query->where('refill_quantity', 0)
                    ->orWhere('provider_id', 0)
                    ->orWhere('provider_id', null)
                    ->orWhere('refill_quantity', null);
            })
            // ;
            ->get();

        $notPresent = Product::whereDoesntHave('warehouses', function ($query) {
            $query->where('warehouses.id', $this->id);
        })
            ->get();

        return Product::whereIn('id', $presentButIncomplete->merge($notPresent)->pluck('id'));
    }
}
