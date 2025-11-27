<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_their_listings(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        
        Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Test Listing',
            'description' => 'Test Description',
            'price' => 100,
            'location' => 'Test Location',
            'condition' => 'new',
            'contact_phone' => '1234567890',
        ]);

        $response = $this->actingAs($user)->get(route('profile.listings'));

        $response->assertStatus(200);
    }

    public function test_user_can_create_listing(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);

        $response = $this->actingAs($user)->post(route('listings.store'), [
            'category_id' => $category->id,
            'title' => 'New Listing',
            'description' => 'New Description',
            'price' => 200,
            'location' => 'New Location',
            'condition' => 'new',
            'contact_phone' => '9876543210',
        ]);

        $response->assertRedirect(route('profile.listings'));
        $this->assertDatabaseHas('listings', [
            'title' => 'New Listing',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_update_their_listing(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        
        $listing = Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Old Title',
            'description' => 'Old Description',
            'price' => 100,
            'location' => 'Old Location',
            'condition' => 'new',
            'contact_phone' => '1234567890',
        ]);

        $response = $this->actingAs($user)->put(route('listings.update', $listing), [
            'category_id' => $category->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'price' => 150,
            'location' => 'Updated Location',
            'condition' => 'used',
            'contact_phone' => '1234567890',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_user_can_delete_their_listing(): void
    {
        $user = User::factory()->create(['role' => Role::CUSTOMER]);
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        
        $listing = Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'To Delete',
            'description' => 'Test Description',
            'price' => 100,
            'location' => 'Test Location',
            'condition' => 'new',
            'contact_phone' => '1234567890',
        ]);

        $response = $this->actingAs($user)->delete(route('listings.destroy', $listing));

        $response->assertRedirect();
        $this->assertDatabaseMissing('listings', ['id' => $listing->id]);
    }

    public function test_user_cannot_update_other_users_listing(): void
    {
        $user1 = User::factory()->create(['role' => Role::CUSTOMER]);
        $user2 = User::factory()->create(['role' => Role::CUSTOMER]);
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        
        $listing = Listing::create([
            'user_id' => $user1->id,
            'category_id' => $category->id,
            'title' => 'User 1 Listing',
            'description' => 'Test Description',
            'price' => 100,
            'location' => 'Test Location',
            'condition' => 'new',
            'contact_phone' => '1234567890',
        ]);

        $response = $this->actingAs($user2)->put(route('listings.update', $listing), [
            'category_id' => $category->id,
            'title' => 'Hacked Title',
            'description' => 'Hacked Description',
            'price' => 999,
            'location' => 'Hacked Location',
            'condition' => 'new',
            'contact_phone' => '1234567890',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'title' => 'User 1 Listing',
        ]);
    }

    public function test_user_cannot_delete_other_users_listing(): void
    {
        $user1 = User::factory()->create(['role' => Role::CUSTOMER]);
        $user2 = User::factory()->create(['role' => Role::CUSTOMER]);
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        
        $listing = Listing::create([
            'user_id' => $user1->id,
            'category_id' => $category->id,
            'title' => 'User 1 Listing',
            'description' => 'Test Description',
            'price' => 100,
            'location' => 'Test Location',
            'condition' => 'new',
            'contact_phone' => '1234567890',
        ]);

        $response = $this->actingAs($user2)->delete(route('listings.destroy', $listing));

        $response->assertStatus(403);
        $this->assertDatabaseHas('listings', ['id' => $listing->id]);
    }
}
