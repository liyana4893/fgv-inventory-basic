<?php

namespace Tests\Feature;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ShopModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_create_store_show_edit_update_and_delete_flow(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $payload = [
            'name' => 'Shop A',
            'ssm_no' => 'SSM1234',
            'phone' => '0123456789',
            'address' => 'No. 1 Street',
            'city' => 'Kuala Lumpur',
            'state' => 'WP',
            'country' => 'Malaysia',
            'email' => 'shopa@example.com',
        ];

        $this->actingAs($user)->get(route('shops.create'))->assertOk();
        $this->actingAs($user)->post(route('shops.store'), $payload)
            ->assertRedirect(route('shops.index'));

        $shop = Shop::query()->where('name', 'Shop A')->firstOrFail();
        $this->assertSame($user->id, $shop->user_id);

        $this->actingAs($user)->get(route('shops.show', $shop))->assertOk();
        $this->actingAs($user)->get(route('shops.edit', $shop))->assertOk();

        $this->actingAs($user)->post(route('shops.update', $shop), array_merge($payload, [
            'name' => 'Shop B',
            'email' => 'shopb@example.com',
        ]))->assertRedirect(route('shops.index'));

        $shop->refresh();
        $this->assertSame('Shop B', $shop->name);

        $this->actingAs($user)->get(route('shops.delete', $shop))
            ->assertRedirect(route('shops.index'));
        $this->assertDatabaseMissing('shops', ['id' => $shop->id]);
    }

    public function test_shop_validation_on_store_follows_request_rules(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('shops.store'), [])
            ->assertSessionHasErrors([
                'name', 'ssm_no', 'phone', 'address', 'city', 'state', 'country', 'email',
            ]);
    }

    public function test_shop_routes_are_auth_protected(): void
    {
        $shop = Shop::factory()->create();

        $this->get(route('shops.index'))->assertRedirect('/login');
        $this->get(route('shops.show', $shop))->assertRedirect('/login');
    }

    public function test_authenticated_non_owner_can_still_access_other_user_shop_routes_in_current_behavior(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $shop = Shop::factory()->for($owner)->create();

        $this->actingAs($otherUser)->get(route('shops.show', $shop))->assertOk();
        $this->actingAs($otherUser)->get(route('shops.edit', $shop))->assertOk();
    }
}
