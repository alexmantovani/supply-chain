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
            case 'aborted':
                return "Annullato";
                break;
            case 'waiting':
                return "In attesa";
                break;
            case 'pending':
                return "Parzialmente completo";
                break;
            case 'completed':
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

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function logga($testo)
    {
        $this->logs()->create([
            'description' => $testo,
        ]);
    }
}
