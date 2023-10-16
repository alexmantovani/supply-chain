<?php

namespace App\Jobs;

use App\Models\Dealer;
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
        return; // Per ora salto tutto

        // Faccio la richiesta al DB di Altena
        $response = Soap::to('https://sig-inservices.marchesini.com/mgWSElettronici/WebServiceElettro.asmx')
            ->call('getInfoCode', ['Code' => $this->uuid]);
        Log::info($response);

        // Verifica se la chiamata è andata a buon fine
        if ($response->isSuccessful()) {
            // Estrai i dati dalla risposta
            $data = $response->collect();

            // Ora puoi accedere ai dati specifici
            $productInfo = $data['ResponseData']['getInfoCodeResult'];

            // Puoi fare qualcos'altro con i dati, ad esempio stamparli
            echo "Nome prodotto: " . $productInfo['ProductName'] . "\n";
            echo "Descrizione: " . $productInfo['ProductDescription'] . "\n";
        } else {
            // Gestisci l'errore in caso di chiamata SOAP non riuscita
            $error = $response->getErrorMessage();
            echo "Errore durante la chiamata SOAP: " . $error . "\n";
        }

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

        // DATI DELLA TABELLA DEALERS
        // $table->string('name');
        // $table->string('email')->nullable();
        // $table->string('model')->nullable();
        // $table->string('code')->nullable();
        // $table->string('image_url', 100)->nullable();

        // DATI DELLA TABELLA PRODUCTS
        //   $table->foreignId('dealer_id')->nullable();
        //   $table->foreignId('status_id');
        //   $table->foreignId('provider_id')->nullable();
        //   $table->string('uuid')->unique();
        //   $table->string('name')->nullable();
        //   $table->string('description')->nullable();
        //   $table->string('image_url')->nullable();
        //   $table->unsignedBigInteger('order_code')->nullable();
        //   $table->string('model')->nullable();
        //   $table->string('note')->nullable();
        //   Info da ufficio acquisti
        //   $table->string('unit_of_measure')->nullable();
        //   $table->string('refill_quantity')->default(0);

        $dealer_name = "|||";
        $dealer_model = "|||";
        $dealer_code = "|||";

        $dealer = Dealer::updateOrCreate([
            'name' => $dealer_name,
        ],[
            'model' => $dealer_model,
            'code' => $dealer_code,
        ]);

        // TODO: scaricare i dati dal DB altena e inserirli nel DB
        // TODO: Sistemare
        Product::updateOrCreate(
            [
                'name' => Str::uuid(),
            ],
            [
                'dealer_id' => $dealer->id,
                'order_code' => 0,
                'model' => '',
                'note' => '',
            ]
        );

        // TODO: Aggiornare anche lo stato del prodotto ed eventualmente le info sul dealer

        // TODO: Si potrebbe fare un controllo della risposta ed eventualmente mettere in un log eventuali anomalie presenti nel DB.
    }
}
