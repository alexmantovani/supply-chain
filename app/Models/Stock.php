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

    public function getStatusAttribute()
    {
        // Per prima cosa guardo se per questo articolo ho ordini pendenti
        $pendingOrder = $this->orders()->firstWhere('status', '=', 'placed');
        if ($pendingOrder) {
            return $pendingOrder->status;
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
            return "bg-yellow-400 text-yellow-800";
        }

        if ($this->quantity < 5) {
            return " bg-red-400 text-red-800";
        }

        return " bg-green-400 text-green-800";
    }


}
