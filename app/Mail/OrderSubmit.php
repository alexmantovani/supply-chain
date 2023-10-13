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
        public Order $order,
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@noreply.com', $this->order->warehouse->name),
            subject: 'REFILLER - Nuovo ordine ' . $this->order->uuid,
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
        // $filename = storage_path('tempdir') . "/order.csv";

        // // Se il file $filename esiste lo cancello
        // @unlink($filename);

        // // Stringa da generare
        // // 107578   M02                                                         C030000040        001000000000000000000000

        // $file = fopen($filename, 'w');
        // foreach ($this->order->products as $product) {
        //     $row = [$product->uuid, $product->name, $product->dealer->name, $product->pivot->quantity];
        //     fputcsv($file, $row);
        // }
        // fclose($file);

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
                ->as('order_' . $this->order->uuid . '.txt')
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
