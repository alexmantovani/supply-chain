<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Refill;
use App\Models\User;
use App\Models\Provider;
use App\Models\Warehouse;
use App\Models\Profile;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::factory(5)->create();
        Provider::factory(5)->create();
        Warehouse::factory(5)->create();

        Dealer::factory(2)->create();

        Product::factory(5)->create([
            // 'default_provider_id' => 1,
        ]);

        // Il prodotto id=6 non ha il dealer impostato
        Product::factory()->create();
    }

    /**
     *
     */
    public function test_provider_name(): void
    {
        $provider = Provider::factory()->create();
        $order = Order::factory()->create([
            'provider_id' => $provider->id,
        ]);
        $this->assertEquals($order->provider_name, $provider->name);

        $order = Order::factory()->create([
            'provider_id' => null,
        ]);
        $this->assertEquals($order->provider_name, 'sconosciuto');
    }

    public function test_provider_emails(): void
    {
        $warehouse = Warehouse::factory()->create();
        $provider = Provider::factory()->create();
        $order = Order::factory()->create([
            'provider_id' => $provider->id,
        ]);
        $this->assertEquals($order->provider_emails, $provider->emails);

        $order = Order::factory()->create([
            'provider_id' => null,
            'warehouse_id' => $warehouse->id,
        ]);
        $this->assertEquals($order->provider_emails, $warehouse->fallback_emails);
    }
}
