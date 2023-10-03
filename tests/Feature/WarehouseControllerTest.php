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

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class WarehouseControllerTest extends TestCase
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

    public function test_warehouse_index_can_be_rendered(): void
    {
        $response = $this->get('/warehouse');
        $response->assertStatus(302);

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/warehouse');

        $response->assertStatus(200);
    }

    public function test_warehouse_show_can_be_rendered(): void
    {
        Permission::updateOrCreate(['name' => 'change warehouse']);

        $response = $this->get('/warehouse/show');
        $response->assertStatus(302);

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // $response = $this->actingAs($user)->get('warehouse.show');
        $response = $this->actingAs($user)->call('GET', '/warehouse/1');

        $response->assertStatus(200);
    }



}
