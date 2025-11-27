<?php

namespace Tests\Feature\Admin;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users_index(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_view_users_index(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_create_user_page(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.users.create'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'customer',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'customer',
        ]);
    }

    public function test_admin_cannot_create_user_with_duplicate_email(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Duplicate User',
            'email' => 'existing@example.com',
            'role' => 'customer',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_admin_can_view_edit_user_page(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.users.edit', $user));

        $response->assertStatus(200);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);
        $user = User::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'name' => 'Updated Name',
            'email' => $user->email,
            'role' => 'customer',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_admin_can_update_user_password(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 'customer',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        
        $this->assertTrue(
            \Hash::check('newpassword123', $user->fresh()->password)
        );
    }

    public function test_admin_can_change_user_role(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);
        $user = User::factory()->create(['role' => Role::CUSTOMER]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_non_admin_cannot_create_user(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);

        $response = $this->actingAs($user)->post(route('admin.users.store'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'customer',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_user(): void
    {
        $user1 = User::factory()->create(['role' => Role::CUSTOMER]);
        $user2 = User::factory()->create(['role' => Role::CUSTOMER]);

        $response = $this->actingAs($user1)->put(route('admin.users.update', $user2), [
            'name' => 'Hacked Name',
            'email' => $user2->email,
            'role' => 'admin',
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_user(): void
    {
        $user1 = User::factory()->create(['role' => Role::CUSTOMER]);
        $user2 = User::factory()->create(['role' => Role::CUSTOMER]);

        $response = $this->actingAs($user1)->delete(route('admin.users.destroy', $user2));

        $response->assertStatus(403);
    }
}
