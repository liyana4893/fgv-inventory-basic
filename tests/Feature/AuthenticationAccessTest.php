<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_all_protected_module_index_routes(): void
    {
        $this->get(route('inventories.index'))->assertRedirect('/login');
        $this->get(route('shops.index'))->assertRedirect('/login');
        $this->get(route('users.index'))->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_module_index_routes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('inventories.index'))->assertOk();
        $this->actingAs($user)->get(route('shops.index'))->assertOk();
        $this->actingAs($user)->get(route('users.index'))->assertOk();
    }
}
