<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Log;

class OrderSubmit extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Order $order, public $urgent = false
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $warning = $this->order->hasMissingQuantity();
        return new Envelope(
            from: new Address('noreply@noreply.com', $this->order->warehouse->name),
            subject: ($warning ? "⚠️ " : ($this->urgent ? "🔥 " : '')) . 'REFILLER - Nuovo ordine ' . $this->order->uuid,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order.submit',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Senza il provider_code non genero il file tracciato.txt
        if (!$this->order->provider_id) {
            return [];
        }

        $filename = storage_path('tempdir') . "/order.txt";
        if (is_file($filename)) {
            @unlink($filename);
        }

        $file = fopen($filename, 'w');
        foreach ($this->order->products as $product) {
            $provider_code = str_pad($this->order->provider->provider_code, 6, "0", STR_PAD_LEFT);
            $warehouse = "   M02                                                         ";
            $uuid = str_pad($product->uuid, 18, " ");
            $qty = str_pad($product->pivot->quantity, 5, "0", STR_PAD_LEFT);
            $row =  $provider_code . $warehouse . $uuid . $qty . "0000000000000000000" . "\n";
            fwrite($file, $row);
        }
        fclose($file);

        Log::info("Generating file: " . $filename);

        return [
            // Attachment::fromPath($filename)
            //         ->as('order_' . $this->order->uuid. '.csv')
            //         ->withMime('application/csv'),
            Attachment::fromPath($filename)
                ->as('Order_' . $this->order->uuid . '.txt')
                ->withMime('text/plain'),
        ];
    }


    function arrayToCsvString($input, $delimiter = ',', $enclosure = '"')
    {
        $str = '';
        foreach ($input as $item) {
            $str = $str . $item . $delimiter;
        }
        return rtrim($str, "\n");
    }
}
