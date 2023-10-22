<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refill extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['user', 'product', 'order', 'warehouse', 'provider'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function provider() {
        return $this->belongsTo(Provider::class);
    }

    public function dealer() {
        return $this->product->dealer;
    }

}
