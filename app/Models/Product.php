<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stock() {
        return $this->hasOne(Stock::class);
    }

    public function dealer() {
        return $this->belongsTo(Dealer::class);
    }

    public function refills() {
        return $this->hasMany(Refill::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class);
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    /**
     * Riporta true nel caso in cui il prodotto sia già nella lista dei prodotti in esaurimento.
     */
    public function isLow() {
        return (bool)$this->refills()->where('status', '!=', 'processed')->count();
    }


}
