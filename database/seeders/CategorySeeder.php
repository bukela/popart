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
        // Create Computers category
        $computers = Category::create([
            'name' => 'Computers',
            'slug' => Str::slug('Computers'),
            'description' => 'Desktop computers, laptops, and components',
        ]);

        // Computers > Components
        $components = Category::create([
            'name' => 'Components',
            'slug' => Str::slug('Components'),
            'description' => 'Computer hardware components',
            'parent_id' => $computers->id,
        ]);

        // Computers > Components > Graphics Cards
        Category::create([
            'name' => 'Graphics Cards',
            'slug' => Str::slug('Graphics Cards'),
            'description' => 'GPU and video cards for gaming and professional use',
            'parent_id' => $components->id,
        ]);

        // Computers > Components > CPUs
        Category::create([
            'name' => 'CPUs',
            'slug' => Str::slug('CPUs'),
            'description' => 'Computer processors and CPUs',
            'parent_id' => $components->id,
        ]);

        // Computers > Components > RAM
        Category::create([
            'name' => 'RAM',
            'slug' => Str::slug('RAM'),
            'description' => 'Memory modules and RAM sticks',
            'parent_id' => $components->id,
        ]);

        // Create Mobile Phones category
        $mobilePhones = Category::create([
            'name' => 'Mobile Phones',
            'slug' => Str::slug('Mobile Phones'),
            'description' => 'Smartphones and mobile devices',
        ]);

        // Mobile Phones > Manufacturers
        $phoneManufacturers = Category::create([
            'name' => 'Manufacturers',
            'slug' => Str::slug('Manufacturers'),
            'description' => 'Mobile phone brands and manufacturers',
            'parent_id' => $mobilePhones->id,
        ]);

        // Mobile Phones > Manufacturers > Apple
        Category::create([
            'name' => 'Apple',
            'slug' => Str::slug('Apple'),
            'description' => 'iPhone and Apple mobile devices',
            'parent_id' => $phoneManufacturers->id,
        ]);

        // Mobile Phones > Manufacturers > Samsung
        Category::create([
            'name' => 'Samsung',
            'slug' => Str::slug('Samsung'),
            'description' => 'Samsung Galaxy and Android phones',
            'parent_id' => $phoneManufacturers->id,
        ]);

        // Mobile Phones > Manufacturers > Xiaomi
        Category::create([
            'name' => 'Xiaomi',
            'slug' => Str::slug('Xiaomi'),
            'description' => 'Xiaomi and Redmi smartphones',
            'parent_id' => $phoneManufacturers->id,
        ]);

        // Create Electronics category
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => Str::slug('Electronics'),
            'description' => 'Electronic devices and appliances',
        ]);

        // Electronics > TV
        Category::create([
            'name' => 'TV',
            'slug' => Str::slug('TV'),
            'description' => 'Televisions and smart TVs',
            'parent_id' => $electronics->id,
        ]);

        // Electronics > Speakers
        Category::create([
            'name' => 'Speakers',
            'slug' => Str::slug('Speakers'),
            'description' => 'Audio speakers and sound systems',
            'parent_id' => $electronics->id,
        ]);

        // Electronics > Washing Machines
        $washingMachines = Category::create([
            'name' => 'Washing Machines',
            'slug' => Str::slug('Washing Machines'),
            'description' => 'Home laundry appliances',
            'parent_id' => $electronics->id,
        ]);

        // Electronics > Washing Machines > Manufacturers
        $wmManufacturers = Category::create([
            'name' => 'Manufacturers',
            'slug' => Str::slug('WM Manufacturers'),
            'description' => 'Washing machine brands and manufacturers',
            'parent_id' => $washingMachines->id,
        ]);

        // Electronics > Washing Machines > Manufacturers > LG
        Category::create([
            'name' => 'LG',
            'slug' => Str::slug('LG'),
            'description' => 'LG washing machines and laundry appliances',
            'parent_id' => $wmManufacturers->id,
        ]);

        // Electronics > Washing Machines > Manufacturers > Samsung
        Category::create([
            'name' => 'Samsung',
            'slug' => Str::slug('Samsung WM'),
            'description' => 'Samsung washing machines and laundry appliances',
            'parent_id' => $wmManufacturers->id,
        ]);

        // Electronics > Washing Machines > Manufacturers > Bosch
        Category::create([
            'name' => 'Bosch',
            'slug' => Str::slug('Bosch'),
            'description' => 'Bosch washing machines and laundry appliances',
            'parent_id' => $wmManufacturers->id,
        ]);
    }
}
