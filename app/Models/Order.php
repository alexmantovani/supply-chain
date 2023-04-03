<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getStatusAttribute()
    {
        switch ($this->attributes['status']) {
            case 'placed':
                return "In attesa";
                break;
            case 'processed':
                return "Completato";
                break;

            default:
                return "??" . $this->attributes['status'];
        }
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity');
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
}
