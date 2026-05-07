<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_create_store_show_edit_update_and_delete_flow(): void
    {
        $adminLikeUser = User::factory()->create();

        $this->actingAs($adminLikeUser)->get(route('users.create'))->assertOk();
        $this->actingAs($adminLikeUser)->post(route('users.store'), [
            'name' => 'New User',
            'email' => 'new.user@example.com',
            'password' => 'secret123',
        ])->assertRedirect(route('users.index'));

        $user = User::query()->where('email', 'new.user@example.com')->firstOrFail();

        $this->actingAs($adminLikeUser)->get(route('users.show', $user))->assertOk();
        $this->actingAs($adminLikeUser)->get(route('users.edit', $user))->assertOk();

        $this->actingAs($adminLikeUser)->post(route('users.update', $user), [
            'name' => 'Updated User',
            'email' => 'updated.user@example.com',
            'password' => 'newsecret123',
        ])->assertRedirect(route('users.index'));

        $user->refresh();
        $this->assertSame('Updated User', $user->name);

        $this->actingAs($adminLikeUser)->get(route('users.delete', $user))
            ->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_validation_requires_password_for_post_store_and_post_update_routes(): void
    {
        $authUser = User::factory()->create();
        $targetUser = User::factory()->create();

        $this->actingAs($authUser)->post(route('users.store'), [
            'name' => 'No Password User',
            'email' => 'nopass@example.com',
        ])->assertSessionHasErrors(['password']);

        $this->actingAs($authUser)->post(route('users.update', $targetUser), [
            'name' => 'Updated No Password',
            'email' => 'updated-nopass@example.com',
        ])->assertSessionHasErrors(['password']);
    }

    public function test_user_routes_are_auth_protected_but_not_role_restricted_in_current_behavior(): void
    {
        $targetUser = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->get(route('users.index'))->assertRedirect('/login');
        $this->actingAs($otherUser)->get(route('users.show', $targetUser))->assertOk();
    }
}
