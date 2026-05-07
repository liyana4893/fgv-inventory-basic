<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class InventoryModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_create_store_show_edit_update_and_soft_delete_flow(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('inventories.create'))->assertOk();

        $payload = [
            'name' => 'Mouse',
            'description' => 'Wireless mouse',
            'quantity' => 5,
        ];

        $this->actingAs($user)->post(route('inventories.store'), $payload)
            ->assertRedirect(route('inventories.index'));

        $inventory = Inventory::query()->where('name', 'Mouse')->firstOrFail();
        $this->assertSame($user->id, $inventory->user_id);

        $this->actingAs($user)->get(route('inventories.show', $inventory))->assertOk();
        $this->actingAs($user)->get(route('inventories.edit', $inventory))->assertOk();

        $this->actingAs($user)->post(route('inventories.update', $inventory), [
            'name' => 'Mouse Updated',
            'description' => 'Updated desc',
            'quantity' => 9,
        ])->assertRedirect(route('inventories.index'));

        $inventory->refresh();
        $this->assertSame('Mouse Updated', $inventory->name);
        $this->assertSame(9, $inventory->quantity);

        $this->actingAs($user)->get(route('inventories.delete', $inventory))
            ->assertRedirect(route('inventories.index'));

        $this->assertSoftDeleted('inventories', ['id' => $inventory->id]);
    }

    public function test_inventory_validation_on_store_follows_request_rules(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('inventories.store'), [
            'name' => '',
            'description' => [],
            'quantity' => -1,
        ])->assertSessionHasErrors(['name', 'description', 'quantity']);
    }

    public function test_inventory_authorization_owner_can_view_but_non_owner_cannot(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $inventory = Inventory::factory()->for($owner)->create();

        $this->actingAs($owner)->get(route('inventories.show', $inventory))->assertOk();
        $this->actingAs($otherUser)->get(route('inventories.show', $inventory))->assertForbidden();
        $this->actingAs($otherUser)->get(route('inventories.edit', $inventory))->assertForbidden();
        $this->actingAs($otherUser)->get(route('inventories.delete', $inventory))->assertForbidden();
    }

    public function test_inventory_create_is_denied_when_owner_has_five_items(): void
    {
        $user = User::factory()->create();
        Inventory::factory()->count(5)->for($user)->create();

        $this->actingAs($user)->get(route('inventories.create'))->assertForbidden();
    }

    public function test_inventory_restore_and_force_delete_are_currently_not_authorized_by_owner_policy(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $inventory = Inventory::factory()->for($owner)->create();
        $inventory->delete();

        $this->actingAs($otherUser)->get(route('inventories.restore', $inventory->id))
            ->assertRedirect(route('inventories.index'));
        $this->assertDatabaseHas('inventories', ['id' => $inventory->id, 'deleted_at' => null]);

        $inventory->delete();
        $this->actingAs($otherUser)->get(route('inventories.forceDelete', $inventory->id))
            ->assertRedirect(route('inventories.index'));
        $this->assertDatabaseMissing('inventories', ['id' => $inventory->id]);
    }
}
