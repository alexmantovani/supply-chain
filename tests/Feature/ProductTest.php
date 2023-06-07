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

class ProductTest extends TestCase
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
    public function test_product_is_low(): void
    {
        $product = Product::find(5);
        $warehouse = Warehouse::find(1);

        $refill = Refill::factory()->create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
        ]);

        $this->assertTrue($product->isLow($warehouse));
        $this->assertFalse($product->isLow(Warehouse::find(2)));
        $this->assertEquals($refill->status, 'low');

        $refill->update(['status' => 'ordered']);
        $this->assertTrue($product->isLow($warehouse));
        $this->assertFalse($product->isLow(Warehouse::find(2)));

        $refill->update(['status' => 'completed']);
        $this->assertFalse($product->isLow($warehouse));
        $this->assertFalse($product->isLow(Warehouse::find(2)));
    }
}
