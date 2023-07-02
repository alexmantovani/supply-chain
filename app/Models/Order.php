<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot([
                'quantity',
                'received_quantity',
            ])->withTimestamps();
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

    // In base ai prodotti ricevuti imposta lo status
    // Riporta True nel caso in cui l'ordine sia stato completato
    public function updateStatus()
    {
        $isCompleted = true;

        foreach ($this->products as $product) {
            if ($product->pivot->received_quantity != $product->pivot->quantity) {
                // Log::info('DIVERSI ' . $product->pivot->received_quantity . '!=' . $product->pivot->quantity );
                $isCompleted = false;
                break;
            }
        }

        if ($isCompleted) {
            $this->update([
                'status' => 'completed',
            ]);
        } else {
            $this->update([
                'status' => 'pending',
            ]);
        }

        return $isCompleted;
    }
}
