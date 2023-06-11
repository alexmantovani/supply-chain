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
            from: new Address('noreply@example.com', $this->order->warehouse->name),
            subject: 'Richiesta materiale - Nuovo ordine ' . $this->order->uuid,
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
        $filename = storage_path('tempdir') . "/order.csv";

        // TODO: Se il file $filename esiste lo cancello
        //

        $file = fopen($filename, 'w');
        foreach ($this->order->products as $product) {
            $row = [$product->uuid, $product->name, $product->dealer->name, $product->pivot->quantity];
            fputcsv($file, $row);
        }
        fclose($file);

        return [
            Attachment::fromPath($filename)
                    ->as('order_' . $this->order->uuid. '.csv')
                    ->withMime('application/csv'),
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
