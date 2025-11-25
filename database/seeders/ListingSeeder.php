<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::where('email', 'customer@example.com')->first();
        $faker = Faker::create();

        // Get all category IDs for random assignment
        $categoryIds = Category::pluck('id')->toArray();

        // Serbian cities for realistic locations
        $serbianCities = [
            'Belgrade, Serbia',
            'Novi Sad, Serbia',
            'Niš, Serbia',
            'Kragujevac, Serbia',
            'Subotica, Serbia',
            'Zrenjanin, Serbia',
            'Pančevo, Serbia',
            'Čačak, Serbia',
            'Kraljevo, Serbia',
            'Novi Pazar, Serbia',
            'Kruševac, Serbia',
            'Šabac, Serbia',
            'Valjevo, Serbia',
            'Smederevo, Serbia',
            'Leskovac, Serbia'
        ];

        // Product-specific templates for more realistic titles
        $productTemplates = [
            'computer' => [
                'RTX {model} Gaming Graphics Card',
                'Intel Core i{model} Processor',
                'AMD Ryzen {model} CPU',
                'Corsair DDR{model} {ram}GB RAM',
                'G.Skill Trident Z5 {ram}GB Kit',
                'Samsung {storage}GB SSD',
                'ASUS ROG {model} Motherboard',
                'MSI Gaming {model} Laptop',
                'Dell {model} Desktop PC'
            ],
            'mobile' => [
                'iPhone {model} {storage}GB',
                'Samsung Galaxy {model}',
                'Xiaomi {model} {storage}GB',
                'OnePlus {model} 5G',
                'Apple iPhone {model} Pro',
                'Samsung Galaxy S{model} Ultra',
                'Xiaomi Redmi Note {model}',
                'Google Pixel {model}'
            ],
            'electronics' => [
                'Samsung {size}" QLED 4K TV',
                'LG {size}" OLED Smart TV',
                'Sony {size}" Bravia 4K',
                'Bose {model} Speaker System',
                'JBL {model} Bluetooth Speakers',
                'LG {capacity}kg Washing Machine',
                'Bosch {capacity}kg Washer Dryer',
                'Samsung {capacity}kg EcoBubble',
                'Sony {model} Soundbar'
            ]
        ];

        for ($i = 1; $i <= 100; $i++) {
            $category = Category::find($categoryIds[array_rand($categoryIds)]);
            $categoryName = strtolower($category->name);

            $productType = 'computer';
            if (str_contains($categoryName, 'phone') || str_contains($categoryName, 'apple') || str_contains($categoryName, 'samsung') || str_contains($categoryName, 'xiaomi')) {
                $productType = 'mobile';
            } elseif (str_contains($categoryName, 'tv') || str_contains($categoryName, 'speaker') || str_contains($categoryName, 'washing') || str_contains($categoryName, 'lg') || str_contains($categoryName, 'bosch')) {
                $productType = 'electronics';
            }

            $template = $productTemplates[$productType][array_rand($productTemplates[$productType])];
            $title = str_replace([
                '{model}', '{ram}', '{storage}', '{size}', '{capacity}'
            ], [
                $faker->randomElement(['4090', '4080', '4070', '3060', '3070', '3080']),
                $faker->randomElement(['16', '32', '64']),
                $faker->randomElement(['128', '256', '512']),
                $faker->randomElement(['55', '65', '75', '77']),
                $faker->randomElement(['8', '9', '10'])
            ], $template);

            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $category->id,
                'title' => $title,
                'description' => $faker->text(200),
                'price' => $faker->randomFloat(2, 50, 2500),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($serbianCities),
                'status' => 'active',
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
                'updated_at' => $faker->dateTimeBetween('-7 days', 'now'),
            ]);
        }
    }
}
