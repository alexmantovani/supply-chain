<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Log;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['warehouse'];

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

    public function getProviderNameAttribute() {
        return $this->provider->name ?? 'sconosciuto';
    }

    public function getProviderEmailsAttribute() {
        return $this->provider->emails ?? $this->warehouse->fallback_emails ?? abort(403, 'La mail del fornitore o del magazzino non è stata impostata');
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
            if ($product->pivot->received_quantity !== $product->pivot->quantity) {
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

    public static function getOrdersDoneByYear($numberOfYears = 5)
    {
        $currentYear = date('Y');
        $startYear = $currentYear - $numberOfYears;

        $returnData = array();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            // $su = Order::whereNotIn('status', ['aborted'])
            //     ->whereYear('orders.created_at', '=', $i)
            //     ->get()
            //     ->groupBy('warehouse_id');
            $su = Order::leftJoin('warehouses', 'warehouses.id', 'orders.warehouse_id')
            ->whereNotIn('status', ['aborted'])
                ->whereYear('orders.created_at', '=', $i)
                ->groupBy('warehouse_id')
                ->selectRaw('warehouse_id, COUNT(*) as count, warehouses.name as warehouse_name' )
                ->get();

            // array_push($returnData, $su);
            $returnData[$i] = $su->toArray();
        }

        return $returnData;
    }

    // Riporta true nel caso nell'ordine siano presenti prodotti con quantità uguale a 0
    public function hasMissingQuantity()
    {
        foreach ($this->products as $product) {
            if (!$product->pivot->quantity) {
                return true;
            }
        }

        return false;
    }
}
