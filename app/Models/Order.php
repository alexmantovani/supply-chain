<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function getStatusAttribute()
    // {
    //     switch ($this->attributes['status']) {
    //         case 'aborted':
    //             return "Annullato";
    //             break;
    //         case 'waiting':
    //             return "In attesa";
    //             break;
    //         case 'pending':
    //             return "Parzialmente completo";
    //             break;
    //         case 'completed':
    //             return "Completato";
    //             break;

    //         default:
    //             return "??" . $this->attributes['status'];
    //     }
    // }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function refills()
    {
        return $this->hasMany(Refill::class);
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

    public static function uuid($length = 12)
    {
        $unique = strtoupper(Str::random($length));
        $check = Order::where('uuid', $unique)->first();
        if ($check) {
            return Order::uuid();
        }

        return $unique;
    }

}
