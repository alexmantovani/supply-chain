<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suffix = ['500 ohm', '1,5 x 3', '50 mt', '100 mt', 'bianco', '8 ohm', '200 metri', '1 x 2,5', 'rosso', 'verde'];
        $list = [
            "Cavo sensore/attuatore Omron M12 / Senza terminazione",
            "Cavo Ethernet Schneider Electric",
            "Cavo sensore/attuatore binder 3 cond. M9 Femmina / Senza terminazione, Ø 5.3mm, L. 2m",
            "Prolunga RS PRO, tipo K, -75 → + 260 °C, in PFA, 5m",
            "DC-DC Converter 80-175V IN, 13.8V OUT, 450W",
            "Inverter 24V DC IN, 230V AC OUT, 150W/300W Peak",
            "DC-DC Converter 80-175V IN, 26V OUT, 450W",
            "Inverter 24V DC IN, 230V AC OUT, 1500W/3000W Peak",
            "DC-DC Converter 36-48V IN, 24V OUT, 300W",
            "INTERRUTTORE D'EMERGENZA ED125-B1",
            "INTERRUTTORE D'EMERGENZA SD150A-1 24V CO",
            "Rullo 85x105 LM110 F12 VULKOLLAN",
            "Rullo VK 85x75 LM80 F.25",
            "Ruota trazione 330x135 7 fori",
            "PEDALE ACCELERATORE COMESYS DOPPIO",
            "PEDALE ACCELERATORE COMESYS MOD.3",
            "Clacson elettronico 72V/80V (96V max)",
            "Clacson 24V",
            "Batterie stazionarie / Serie EA: 12V / 20-45-100 Ah",
            "Sistemi modulari litio / Serie EM: Soluzioni da 24V a 820V / da 60 Ah a 300 Ah",
            "Pistola rabboccatore P/1 Economy",
            "Indicatore di flusso NEW + 2 CLAMP",
        ];

        foreach ($list as $component) {
            \App\Models\Product::create([
                'name' => $component,// . ' ' . $suffix[rand(0, 9)],
                'uuid' => Str::uuid(),
                'dealer_id' => rand(1, 100),
            ]);
        }
    }
}
