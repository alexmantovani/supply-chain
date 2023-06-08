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
        sleep(10);
        $this->product->update([
            'name' => 'aaacode',
            'dealer_id' => 1,
            'refill_quantity' => 0,
            'order_code' => 0,
            'model' => ''
        ]);

        // TODO: scaricare i dati dal DB altena e inserirli nel DB
        Log::info("Fine");
    }
}
