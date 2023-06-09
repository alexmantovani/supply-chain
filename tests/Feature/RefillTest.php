<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Refill;
use App\Models\User;
use App\Models\Provider;
use App\Models\Warehouse;
use App\Models\Profile;

class RefillTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::factory(5)->create();
        Provider::factory(5)->create();
        Warehouse::factory(5)->create();

        Dealer::factory(3)->create([
            'provider_id' => 5,
        ]);

        Product::factory(5)->create([
            'dealer_id' => 3,
        ]);
    }

    /**
     *
     */
    public function test_dealer(): void
    {
        $provider = Provider::find(5);

        $refill = Refill::factory()->create([
            'product_id' => 5,
            'warehouse_id' => 1,
        ]);

        $this->assertEquals($refill->dealer()->provider->name, $provider->name);
        $this->assertNull($refill->order_id);
    }

    public function test_ask_refill(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('warehouse/1/refill');
        $response->assertStatus(200);
    }
}
