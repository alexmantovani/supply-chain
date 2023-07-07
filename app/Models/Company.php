<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function orders() {
        return $this->hasManyThrough(Order::class, Warehouse::class);
    }

    public function refills() {
        return $this->hasManyThrough(Refill::class, Warehouse::class);
    }

    public function warehouses() {
        return $this->hasMany(Warehouse::class);
    }

    public function dealers() {
        return $this->hasMany(Dealer::class);
    }

    public function providers() {
        return $this->hasMany(Provider::class);
    }

}
