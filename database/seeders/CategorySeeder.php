<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create parent categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => Str::slug('Electronics'),
            'description' => 'Electronic devices and components',
        ]);

        $vehicles = Category::create([
            'name' => 'Vehicles',
            'slug' => Str::slug('Vehicles'),
            'description' => 'Cars, motorcycles, bicycles, and parts',
        ]);

        $services = Category::create([
            'name' => 'Services',
            'slug' => Str::slug('Services'),
            'description' => 'Professional and personal services',
        ]);

        // Electronics subcategories
        $computers = Category::create([
            'name' => 'Computers',
            'slug' => Str::slug('Computers'),
            'description' => 'Desktop and laptop computers',
            'parent_id' => $electronics->id,
        ]);

        $phones = Category::create([
            'name' => 'Mobile Phones',
            'slug' => Str::slug('Mobile Phones'),
            'description' => 'Smartphones and feature phones',
            'parent_id' => $electronics->id,
        ]);

        $tvAudio = Category::create([
            'name' => 'TV & Audio',
            'slug' => Str::slug('TV & Audio'),
            'description' => 'Televisions and audio equipment',
            'parent_id' => $electronics->id,
        ]);

        // Computer subcategories (3rd level)
        Category::create([
            'name' => 'Components',
            'slug' => Str::slug('Components'),
            'description' => 'Computer parts and components',
            'parent_id' => $computers->id,
        ]);

        $components = Category::where('slug', Str::slug('Components'))->first();

        // Component subcategories (4th level - example: Computers->Components->Graphics cards)
        Category::create([
            'name' => 'Graphics Cards',
            'slug' => Str::slug('Graphics Cards'),
            'description' => 'GPU and video cards',
            'parent_id' => $components->id,
        ]);

        Category::create([
            'name' => 'Processors',
            'slug' => Str::slug('Processors'),
            'description' => 'CPU processors',
            'parent_id' => $components->id,
        ]);

        Category::create([
            'name' => 'Memory',
            'slug' => Str::slug('Memory'),
            'description' => 'RAM and storage',
            'parent_id' => $components->id,
        ]);

        Category::create([
            'name' => 'Laptops',
            'slug' => Str::slug('Laptops'),
            'description' => 'Laptop computers',
            'parent_id' => $computers->id,
        ]);

        Category::create([
            'name' => 'Desktops',
            'slug' => Str::slug('Desktops'),
            'description' => 'Desktop computers',
            'parent_id' => $computers->id,
        ]);

        // Vehicles subcategories
        Category::create([
            'name' => 'Cars',
            'slug' => Str::slug('Cars'),
            'description' => 'Automobiles and car parts',
            'parent_id' => $vehicles->id,
        ]);

        Category::create([
            'name' => 'Motorcycles',
            'slug' => Str::slug('Motorcycles'),
            'description' => 'Motorcycles and parts',
            'parent_id' => $vehicles->id,
        ]);

        Category::create([
            'name' => 'Bicycles',
            'slug' => Str::slug('Bicycles'),
            'description' => 'Bicycles and accessories',
            'parent_id' => $vehicles->id,
        ]);
    }
}
