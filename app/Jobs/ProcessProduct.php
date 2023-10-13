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

    public $uuid;

    /**
     * Create a new job instance.
     */
    public function __construct(
        // public Product $product,
        $uuid
    ) {
        $this->uuid = $uuid;
        //
    }

    /**
     * Execute the job.
     * Questo processo viene chiamato in modo "Sincrono"
     */
    public function handle(): void
    {
        // Faccio la richiesta al DB di Altena
        $productInfo = Soap::to('https://sig-inservices.marchesini.com/mgWSElettronici/WebServiceElettro.asmx')->call('getInfoCode', ['Code' => $this->uuid]);
        Log::info($productInfo);

        // TODO: da ricavare da $productInfo
        // Dati relativi al prodotto
        // $name = $data[1];
        // $dealer = $data[5];
        // $status = $data[2];
        // if ($status == '') $status = 'OK';

        // $productStatus = ProductStatus::firstWhere('code', $status);

        // // Dati relativi al produttore
        // $dealer_model = $data[6];
        // $dealer_code = $data[7];

        // $dealer = Dealer::updateOrCreate([
        //     'provider_id' => 1, // TODO: Per ora lo forso sempre al Magazzino centrale MG
        //     'name' => $dealer,
        // ], [
        //     'model' => $dealer_model,
        //     'code' => $dealer_code,
        // ]);

        // TODO: scaricare i dati dal DB altena e inserirli nel DB
        // TODO: Sistemare
        Product::updateOrCreate(
            [
                'name' => Str::uuid(),
            ],
            [
                'dealer_id' => rand(1, 5),
                // 'refill_quantity' => 0,
                'order_code' => 0,
                'model' => '',
                'note' => '',
            ]
        );

        // TODO: Aggiornare anche lo stato del prodotto ed eventualmente le info sul dealer

        // TODO: Si potrebbe fare un controllo della risposta ed eventualmente mettere in un log eventuali anomalie presenti nel DB.
    }
}
