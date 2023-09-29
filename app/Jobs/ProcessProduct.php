<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RicorocksDigitalAgency\Soap\Facades\Soap;

class ProcessProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Product $product,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("ProcessProduct" . $this->product->uuid);

        $productInfo = Soap::to('https://sig-inservices.marchesini.com/mgWSElettronici/WebServiceElettro.asmx')->call('getInfoCode', ['Code' => $this->product->uuid]);
        Log::info($productInfo);

        // TODO: Sistemare
        $this->product->update([
            'name' => Str::uuid(),
            'dealer_id' => rand(1,5),
            // 'refill_quantity' => 0,
            'order_code' => 0,
            'model' => ''
        ]);

        // TODO: Vedere se è fattibile e ha senso
        // $this->emit('productUpdated', $this->product);

        // TODO: scaricare i dati dal DB altena e inserirli nel DB
        Log::info("Fine");
    }
}
