<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    // public function setUp() :void
    // {
    //     parent::setUp();

    //     $role = Role::create(['name' => 'super-admin']);
    //     $role->syncPermissions([
    //         Permission::create([
    //             'name' => 'edit warehouse',
    //         ]),
    //         Permission::create([
    //             'name' => 'create warehouse',
    //         ]),
    //         Permission::create([
    //             'name' => 'delete warehouse',
    //         ]),
    //         Permission::create([
    //             'name' => 'change warehouse',
    //         ]),
    //         Permission::create([
    //             'name' => 'handle order',
    //         ]),
    //     ], 'web');

    //     $this->user = User::factory()->create();
    //     $this->user->assignRole(['super-admin']);

    // }
    protected function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

    // public function test_profile_page_is_displayed(): void
    // {
    //     // $user = User::factory()->create();
    //     // Profile::create([
    //     //     'user_id' => $user->id,
    //     // ]);

    //     // $role = Role::create(['name' => 'super-admin']);
    //     // $user = User::factory()->create();
    //     // $this->user->assignRole(['super-admin']);

    //     $user = User::factory()->create();

    //     $response = $this
    //         ->actingAs($user)
    //         ->get('/profile');

    //     $response->assertOk();
    // }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
