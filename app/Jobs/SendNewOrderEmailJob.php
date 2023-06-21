<?php

namespace App\Jobs;

use App\Mail\OrderSubmit;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;

class SendNewOrderEmailJob implements ShouldQueue
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

        Mail::to($this->order->provider->email)
            ->cc($moreUsers ?: [])
            ->send(new OrderSubmit($this->order));
    }
}
