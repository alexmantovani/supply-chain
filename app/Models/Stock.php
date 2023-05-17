<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function orders() {
        return $this->product->orders();
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function getStatusAttribute()
    {
        // Per prima cosa guardo se per questo articolo ho ordini pendenti
        $pendingOrder = $this->orders()->firstWhere('status', '=', 'placed');
        if ($pendingOrder) {
            return $pendingOrder->status;
        }

        if ($this->quantity == 0) {
            return "Esaurito";
        }

        if ($this->quantity < 5) {
            return "Basso";
        }

        return "Regolare";
    }

    public function getStatusColorAttribute()
    {
        // Per prima cosa guardo se per questo articolo ho ordini pendenti
        $pendingOrder = $this->orders()->firstWhere('status', '=', 'placed');
        if ($pendingOrder) {
            return "border border-yellow-400 text-yellow-600 text-xs dark:text-yellow-200";
        }

        if ($this->quantity < 5) {
            return " border border-red-400 text-red-800 bg-transparent text-xs dark:text-red-400";
        }

        return " border border-green-200 text-green-800 text-xs dark:text-green-400";
    }


}
