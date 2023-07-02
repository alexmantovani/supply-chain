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
        return $this->hasMany(Order::class);
    }

    public function refills() {
        return $this->hasMany(Refill::class);
    }

    public function warehouses() {
        return $this->hasMany(Warehouse::class);
    }



}
