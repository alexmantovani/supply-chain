<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use App\Models\Order;
use App\Models\Warehouse;
use App\Models\Refill;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSubmit;
use Log;

class SubmitOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:submit-orders';
    protected $signature = 'orders:submit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invia mail per richiedere materiale in esaurimento.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('- Start job orders:submit');

        $warehouses = Warehouse::all();
        foreach ($warehouses as $warehouse) {
            $groups = $warehouse->refills()
                ->whereIn('status', ['low', 'urgent'])
                ->where('quantity', '>', 0)
                ->join('products', 'products.id', '=', 'refills.product_id')
                ->join('dealers', 'dealers.id', '=', 'dealer_id')
                ->join('providers', 'providers.id', '=', 'dealers.provider_id')
                ->select('refills.*', 'products.dealer_id', 'dealers.name', 'providers.id as provider_id')
                ->get()
                ->groupBy('provider_id');

            // L'elenco del materiale in esaurimento è raggruppato in base al fornitore
            foreach ($groups as $provider_id => $refills) {
                $order = Order::create([
                    'provider_id' => $provider_id,
                    'warehouse_id' => $warehouse->id,
                    'uuid' => Order::uuid(),
                ]);
                $this->info('Creato ordine ' . $order->uuid);

                $products = [];
                foreach ($refills as $refill) {
                    $products[$refill->product_id] = ['quantity' => $refill->quantity];

                    // Segno questi prodotti come ordinati
                    $refill->update([
                        'status' => 'ordered',
                        'order_id' => $order->id,
                    ]);
                }
                $order->products()->sync($products);

                // Mail::to($order->provider->email)->send(new OrderSubmit($order));
                SendEmailJob::dispatch($order);

                $order->logs()->create([
                    'description' => 'Emesso ordine',
                    'type' => 'info',
                ]);
            }
        }
    }
}
