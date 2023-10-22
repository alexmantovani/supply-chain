<?php

namespace App\Jobs;

use App\Mail\OrderAborted;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;

class SendAbortOrderEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Order $order,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $moreUsers = array_filter(array_map('trim', explode(',', $this->order->warehouse->emails)));
        $providerEmails = array_filter(array_map('trim', explode(',', $this->order->provider_emails)));

        Mail::to($providerEmails)
            ->cc($moreUsers ?: [])
            ->send(new OrderAborted($this->order));

        $this->order->logs()->create([
            'description' => 'Inviata mail di annullamento ordine a ' . $this->order->provider_emails,
            'type' => 'info',
        ]);
    }
}
