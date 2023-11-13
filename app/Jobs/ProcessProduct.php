<?php

namespace App\Jobs;

use App\Models\Dealer;
use App\Models\Product;
use App\Models\ProductStatus;
use FontLib\TrueType\Collection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RicorocksDigitalAgency\Soap\Facades\Soap;
use SimpleXMLElement;

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

    /*
     * Riporta una Collection contenete queste info:
     *  "ITEM" => "E01377734801"
     *  "DESCRIPTION" => "ALIMENTATORE PARAL.5A 24VDC 6EP1333-3BA10 (EX 3BA00) SIEMENS"
     *  "BRAND" => "SIEMENS S.P.A"
     *  "PRODUCT_CODE" => "6EP1333-3BA10"
     *  "MODEL" => "SITOP PSU200M/1-2AC/"
     *  "STATE" => ""
     *  "NOTE" => "Marca: SIEMENS Codice d'ordinazione: 6EP1333-3BA10 Descrizione: ALIMENTATORE Vin:1x120-230-500Vac/Vout:24Vdc/Iout:5A/P=120W Modello: SITOP PSU200M/1-2AC/DC24V/5"
     */
    public function getCodeInfoFromAltena($uuid)
    {
        $url = "https://sig-inservices.marchesini.com/mgWSElettronici/WebServiceElettro.asmx";
        // $url = "http://127.0.0.1:81/tempconvert.asmx";

        $xml_data = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
          <soap12:Body>
            <getInfoCode xmlns="http://tempuri.org/">
              <Code>' . $uuid . '</Code>
            </getInfoCode>
          </soap12:Body>
        </soap12:Envelope>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8'));

        $response = curl_exec($ch);

        $errNo = curl_errno($ch);
        $errMsg = curl_error($ch);
        curl_close($ch);

        $data = [];
        if ($errNo) {
            Log::error('Errore cURL: ' . $errMsg);
            return null;
        }

        // Parsing the response as a SimpleXMLElement
        $responseXml = new SimpleXMLElement($response);
        $jsonString = str_replace("\n","",$responseXml->children('http://www.w3.org/2003/05/soap-envelope')->Body->children()->getInfoCodeResponse->getInfoCodeResult->__toString());
        $data = json_decode($jsonString)[0];
        return collect($data);
    }

    /**
     * Execute the job.
     * Questo processo viene chiamato in modo "Sincrono"
     */
    public function handle(): void
    {
        // Faccio la richiesta al DB di Altena
        // $response = Soap::to('https://sig-inservices.marchesini.com/mgWSElettronici/WebServiceElettro.asmx')
        //     ->call('getInfoCode', ['Code' => $this->uuid]);

        $response = $this->getCodeInfoFromAltena(trim($this->uuid));

        // Se la richiesta fallisce, non vado oltre
        if (!$response) return;

        // $response["ITEM"];
        $name = trim($response["DESCRIPTION"]);
        $dealer_name = trim($response["BRAND"]) ?? '';
        $code = trim($response["PRODUCT_CODE"]) ?? '';
        $model = trim($response["MODEL"]) ?? '';

        // Controlli di sicurezza sulla risposta
        if (strlen($name) < 1) return; // Devo avere il nome dell'articolo
        if (strlen($response["ITEM"]) < 1) return; // Deve esserci l'UUID

        $status = $response["STATE"] ?? '';
        if ($status == '') $status = 'OK';
        $productStatus = ProductStatus::firstWhere('code', $status);
        if (!$productStatus) {
            abort(403, "Product status not found $status");
        }

        $dealer = Dealer::firstOrCreate([
            'name' => $dealer_name,
        ]);

        Product::updateOrCreate(
            [
                'uuid' => $this->uuid,
            ],
            [
                'name' => $name,
                'dealer_id' => $dealer->id,
                'status_id' => $productStatus->id,
                'code' => $code,
                'model' => $model,
                'note' => '',
            ]
        );

        Log::info("Prodotto aggiornato in base ai dati del DB di Altena: $this->uuid");
    }
}
