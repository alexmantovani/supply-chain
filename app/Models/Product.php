<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use DOMDocument;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['dealer', 'status'];

    public function getReceivedAttribute()
    {
        $quantity = $this->orders
            ->whereNotIn('status', ['aborted'])
            ->sum('pivot.received_quantity');

        return $quantity;
    }

    public function getOrderedAttribute()
    {
        $quantity = $this->orders
            ->whereNotIn('status', ['aborted'])
            ->sum('pivot.quantity');

        return $quantity;
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function status()
    {
        return $this->belongsTo(ProductStatus::class);
    }

    public function refills()
    {
        return $this->hasMany(Refill::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot([
                'quantity',
                'received_quantity',
            ])
            ->withTimestamps();
    }

    public function refillQuantity($warehouse_id)
    {
        $default = ProductDefault::where('warehouse_id', $warehouse_id)
            ->where('product_id', $this->id)
            ->first();

        return $default->refill_quantity ?? 0;
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    /**
     * Riporta true nel caso in cui il prodotto sia già nella lista dei prodotti in esaurimento.
     */
    public function isLow(Warehouse $warehouse)
    {
        return 0 < Refill::where('warehouse_id', $warehouse->id)
            ->whereIn('status', ['low', 'urgent', 'ordered'])
            ->where('product_id', $this->id)
            ->count();
    }

    public function isOrdinable()
    {
        return (bool)$this->status->ordinable;
    }

    // Riporta true se il prodotto è stato consegnato
    public function isArrived()
    {
        if ($this->pivot->received_quantity == $this->pivot->quantity) {
            return true;
        }

        return false;
    }

    // public function received()
    // {
    //     return $this->orders->sum('pivot.received_quantity');
    // }

    public function getOrdersByYear($numberOfYears = 5)
    {
        $currentYear = date('Y');
        $startYear = $currentYear - $numberOfYears;

        $returnData = array();
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $su = $this->orders()
                ->whereYear('orders.created_at', '=', $i)
                ->sum('received_quantity');

            // array_push($returnData, $su);
            $returnData[$i] = $su;
        }
        return $returnData;
    }

    // public function orderedInLastYears($numberOfYears = 5)
    // {
    //     return $this->orders
    //         ->groupBy(function ($val) {
    //             return \Carbon\Carbon::parse($val->created_at)->format('Y');
    //         });
    // }

    public function parseHtml()
    {
        $doc = new DOMDocument();
        $doc->loadHTML("
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head><title>
	Visualizzazione testi
</title><meta http-equiv=\"Cache-Control\" content=\"no-cache\" />
  <meta http-equiv=\"Pragma\" content=\"no-cache\" />
<meta http-equiv=\"Expires\" content=\"-1\" />
<link rel=\"stylesheet\" media=\"all\"  href=\"/Styles.css\" />
</head>
<body>
    <form method=\"post\" action=\"./WebNote.aspx?CODE=6731869&amp;ITEM=E20061100050\" id=\"form1\">
<input type=\"hidden\" name=\"__VIEWSTATE\" id=\"__VIEWSTATE\" value=\"vjsCxgEv5F/iq5SHRItKKttdNaICNL724FNs7rdCJa/PmUp1pjGJfvT1SXyXuL/DmTSgfieFVyG9DpQ7xYMlFTN62OB0bZNmG3EgzaKC+AI=\" />

<input type=\"hidden\" name=\"__VIEWSTATEGENERATOR\" id=\"__VIEWSTATEGENERATOR\" value=\"FC5F86E7\" />
    <div>
     <table id=\"TableNote\" width=\"100%\">
	<tr class=\"mg_IGBox\">
		<td align=\"left\" colspan=\"3\"><b>Visualizzazione Testi</b></td>
	</tr><tr>
		<td class=\"mg_IGLabel\" align=\"left\" width=\"15%\">Cod. Articolo</td><td class=\"mg_IGColTesti\" align=\"left\" width=\"15%\">E20061100050</td><td class=\"mg_IGColTesti\" align=\"left\">CONNETTORE FEMM.DIRITTO 1662298 SACC-M12FS-5CON-PG7 PHOENIX</td>
	</tr><tr>
		<td colspan=\"3\"></td>
	</tr><tr class=\"mg_IGBox\">
		<td align=\"left\" colspan=\"3\"><b></b></td>
	</tr><tr>
		<td class=\"mg_IGColTesti\" align=\"left\" colspan=\"3\">MARCA: PHOENIX CONTACT<br>CODICE ORDINAZIONE: 166298<br>DESCRIZIONE: CONN.FEMM.DIRITTO 1662298 SACC-M12FS-5CON-PG7 PHOENIX<br>MODELLO: SACC-M12FS-5CON-PG7<br></td>
	</tr>
</table>
    </div>
    </form>
</body>
</html>
        ");

        $tables = $doc->getElementById('TableNote');
        // $tables = $table->getElementsByTagName('td');
        $rows = $tables->getElementsByTagName('tr');

        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            if ($cols->count() > 2) {
                $uuid = $cols[1]->textContent;
                $name = $cols[2]->textContent;
                break;
            }
        }

        print($uuid . ' ' . $name);
    }
}
