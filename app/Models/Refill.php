<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refill extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getStatusAttribute()
    {
        if ($this->product->stock) {
            if ($this->product->stock->quantity == 0) return "esaurito";
        }

        return "in esaurimento";
    }

    public function getStatusColorAttribute()
    {
        return "text-yellow-600";
    }

    public function getStatusBackgroundColorAttribute()
    {
        return "bg-red-300";
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function dealer() {
        return $this->product->dealer;
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }


}
