<?php

namespace Tests\Feature\Admin;

use App\Enums\Role;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_categories_index(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.categories.index'));

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_view_categories_index(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);

        $response = $this->actingAs($user)->get(route('admin.categories.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_create_category(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'parent_id' => null,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'parent_id' => null,
        ]);
    }

    public function test_admin_cannot_create_category_with_duplicate_slug(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);
        Category::create(['name' => 'Electronics', 'slug' => 'electronics']);

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Electronics 2',
            'slug' => 'electronics',
            'parent_id' => null,
        ]);

        $response->assertSessionHasErrors('slug');
    }

    public function test_admin_can_update_category(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);
        $category = Category::create(['name' => 'Old Name', 'slug' => 'old-name']);

        $response = $this->actingAs($admin)->put(route('admin.categories.update', $category), [
            'name' => 'Updated Name',
            'slug' => 'updated-name',
            'parent_id' => null,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Name',
            'slug' => 'updated-name',
        ]);
    }

    public function test_admin_can_delete_category(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);
        $category = Category::create(['name' => 'To Delete', 'slug' => 'to-delete']);

        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_non_admin_cannot_create_category(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);

        $response = $this->actingAs($user)->post(route('admin.categories.store'), [
            'name' => 'Hacked Category',
            'slug' => 'hacked-category',
            'parent_id' => null,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_category(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);

        $response = $this->actingAs($user)->put(route('admin.categories.update', $category), [
            'name' => 'Hacked Name',
            'slug' => 'hacked-name',
            'parent_id' => null,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_category(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);

        $response = $this->actingAs($user)->delete(route('admin.categories.destroy', $category));

        $response->assertStatus(403);
    }

    public function test_category_with_special_characters_in_slug(): void
    {
        $admin = User::factory()->create(['role' => Role::ADMIN]);

        $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'parent_id' => null,
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
        ]);
    }
}
