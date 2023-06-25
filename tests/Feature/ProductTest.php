<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\Product;
use App\Models\ProductStatus;
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
        $product_a = Product::find(5);
        $product_b = Product::find(4);
        $warehouse_a = Warehouse::find(1);
        $warehouse_b = Warehouse::find(2);

        $refill = Refill::factory()->create([
            'product_id' => $product_a->id,
            'warehouse_id' => $warehouse_a->id,
        ]);

        Refill::factory()->create([
            'product_id' => $product_b->id,
            'warehouse_id' => $warehouse_b->id,
        ]);

        $this->assertTrue($product_a->isLow($warehouse_a));
        $this->assertFalse($product_a->isLow($warehouse_b));
        $this->assertEquals($refill->status, 'low');

        $this->assertFalse($product_b->isLow($warehouse_a));
        $this->assertTrue($product_b->isLow($warehouse_b));

        // Passo allo stato "ordinato"
        $refill->update(['status' => 'ordered']);
        $this->assertTrue($product_a->isLow($warehouse_a));
        $this->assertFalse($product_a->isLow($warehouse_b));

        $this->assertFalse($product_b->isLow($warehouse_a));
        $this->assertTrue($product_b->isLow($warehouse_b));

        // Passo allo stato "completato"
        $refill->update(['status' => 'completed']);
        $this->assertFalse($product_a->isLow($warehouse_a));
        $this->assertFalse($product_a->isLow($warehouse_b));

        $this->assertFalse($product_b->isLow($warehouse_a));
        $this->assertTrue($product_b->isLow($warehouse_b));
    }

    public function test_product_is_ordinable_true(): void
    {
        $product_status = ProductStatus::create([
            'code' => 'ok',
            'ordinable' => true,
        ]);
        $product = Product::factory()->create([
            'dealer_id' => 1,
            'status_id' => $product_status->id,
        ]);

        $this->assertTrue($product->isOrdinable());
    }

    public function test_product_is_ordinable_false(): void
    {
        $product_status = ProductStatus::create([
            'code' => 'ok',
            'ordinable' => false,
        ]);
        $product = Product::factory()->create([
            'dealer_id' => 1,
            'status_id' => $product_status->id,
        ]);

        $this->assertFalse($product->isOrdinable());
    }


    // public function test_rusco(): void
    // {
    //     $product = Product::find(5);
    //     $product->parseHtml();
    // }
}
