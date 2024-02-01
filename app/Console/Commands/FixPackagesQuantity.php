<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class FixPackagesQuantity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-packages-quantity {csvFileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importo il CSV che contiene il numero di prodotti per confezione';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $csvFileName = $this->argument('csvFileName');
        $this->info('Analizzo il file ' . $csvFileName);

        if (!File::exists($csvFileName)) {
            $this->error('Il percorso del file non esiste: ' . $csvFileName);
            return;
        }

        $found = 0;

        // Apro il CSV
        $csv = fopen($csvFileName, 'r');

        // Leggo il CSV
        while (($data = fgetcsv($csv, 1000, ';')) !== FALSE) {
            $uuid = $data[0];
            if ($uuid == 'Codice') continue;

            // Ricavo il prodotto dal codice
            $product = Product::firstWhere('uuid', $uuid);

            if (!$product) {
                $this->error("Prodotto non trovato: " . $uuid);
            } else {
                $product->update([
                    'pieces_in_package' => $data[2],
                ]);
                $found++;
            }
        }

        fclose($csv);

        $this->info("Importati pezzi per confezione di " . $found . " prodotti.");
    }
}
