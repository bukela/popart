<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $computers = Category::create([
            'name' => 'Computers',
            'slug' => 'computers',
            'description' => 'Desktop computers, laptops, and components',
        ]);

        $components = Category::create([
            'name' => 'Components',
            'slug' => 'components',
            'description' => 'Computer hardware components',
            'parent_id' => $computers->id,
        ]);

        Category::create([
            'name' => 'CPUs',
            'slug' => 'cpus',
            'description' => 'Computer processors',
            'parent_id' => $components->id,
        ]);

        Category::create([
            'name' => 'Graphics Cards',
            'slug' => 'graphics-cards',
            'description' => 'GPU and video cards',
            'parent_id' => $components->id,
        ]);

        // Level 3: RAM
        Category::create([
            'name' => 'RAM',
            'slug' => 'ram',
            'description' => 'Memory modules',
            'parent_id' => $components->id,
        ]);

        $peripherals = Category::create([
            'name' => 'Peripherals',
            'slug' => 'peripherals',
            'description' => 'Computer peripherals and accessories',
            'parent_id' => $computers->id,
        ]);

        Category::create([
            'name' => 'Mouse',
            'slug' => 'mouse',
            'description' => 'Computer mice',
            'parent_id' => $peripherals->id,
        ]);

        Category::create([
            'name' => 'Keyboard',
            'slug' => 'keyboard',
            'description' => 'Computer keyboards',
            'parent_id' => $peripherals->id,
        ]);

        Category::create([
            'name' => 'Speakers',
            'slug' => 'speakers',
            'description' => 'Computer speakers',
            'parent_id' => $peripherals->id,
        ]);

        $mobilePhones = Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'description' => 'Smartphones and mobile devices',
        ]);

        $manufacturers = Category::create([
            'name' => 'Manufacturers',
            'slug' => 'manufacturers',
            'description' => 'Mobile phone manufacturers',
            'parent_id' => $mobilePhones->id,
        ]);

        Category::create([
            'name' => 'Apple',
            'slug' => 'apple',
            'description' => 'Apple iPhones',
            'parent_id' => $manufacturers->id,
        ]);

        Category::create([
            'name' => 'Google',
            'slug' => 'google',
            'description' => 'Google Pixel phones',
            'parent_id' => $manufacturers->id,
        ]);

        Category::create([
            'name' => 'Samsung',
            'slug' => 'samsung',
            'description' => 'Samsung Galaxy phones',
            'parent_id' => $manufacturers->id,
        ]);

        Category::create([
            'name' => 'Xiaomi',
            'slug' => 'xiaomi',
            'description' => 'Xiaomi and Redmi phones',
            'parent_id' => $manufacturers->id,
        ]);
    }
}
