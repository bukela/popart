<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'customer@example.com')->first();
        $faker = Faker::create();

        $cities = [
            'Belgrade', 'Novi Sad', 'Niš', 'Kragujevac', 'Subotica',
            'Zrenjanin', 'Pančevo', 'Čačak', 'Kraljevo', 'Leskovac'
        ];

        $cpuCategory = Category::where('slug', 'cpus')->first();
        $gpuCategory = Category::where('slug', 'graphics-cards')->first();
        $ramCategory = Category::where('slug', 'ram')->first();
        $mouseCategory = Category::where('slug', 'mouse')->first();
        $keyboardCategory = Category::where('slug', 'keyboard')->first();
        $speakersCategory = Category::where('slug', 'speakers')->first();
        $appleCategory = Category::where('slug', 'apple')->first();
        $googleCategory = Category::where('slug', 'google')->first();
        $samsungCategory = Category::where('slug', 'samsung')->first();
        $xiaomiCategory = Category::where('slug', 'xiaomi')->first();

        $cpuModels = [
            'Intel Core i9-14900K', 'Intel Core i7-14700K', 'Intel Core i5-14600K',
            'AMD Ryzen 9 7950X', 'AMD Ryzen 9 7900X', 'AMD Ryzen 7 7800X3D',
            'AMD Ryzen 7 7700X', 'AMD Ryzen 5 7600X', 'Intel Core i9-13900K',
            'Intel Core i7-13700K', 'Intel Core i5-13600K', 'AMD Ryzen 9 5950X',
            'AMD Ryzen 9 5900X', 'AMD Ryzen 7 5800X3D', 'AMD Ryzen 7 5700X',
            'Intel Core i5-12600K', 'AMD Ryzen 5 5600X', 'Intel Core i3-12100F',
            'AMD Ryzen 5 5500', 'Intel Core i5-11400F'
        ];

        foreach ($cpuModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $cpuCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' Excellent condition, tested and working perfectly.',
                'price' => $faker->randomFloat(2, 100, 600),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        $gpuModels = [
            'NVIDIA RTX 4090 24GB', 'NVIDIA RTX 4080 16GB', 'NVIDIA RTX 4070 Ti 12GB',
            'NVIDIA RTX 4070 12GB', 'NVIDIA RTX 4060 Ti 8GB', 'NVIDIA RTX 4060 8GB',
            'AMD RX 7900 XTX 24GB', 'AMD RX 7900 XT 20GB', 'AMD RX 7800 XT 16GB',
            'AMD RX 7700 XT 12GB', 'AMD RX 7600 8GB', 'NVIDIA RTX 3090 24GB',
            'NVIDIA RTX 3080 Ti 12GB', 'NVIDIA RTX 3080 10GB', 'NVIDIA RTX 3070 Ti 8GB',
            'NVIDIA RTX 3070 8GB', 'NVIDIA RTX 3060 Ti 8GB', 'AMD RX 6900 XT 16GB',
            'AMD RX 6800 XT 16GB', 'NVIDIA RTX 3060 12GB'
        ];

        foreach ($gpuModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $gpuCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' Never used for mining, great for gaming and rendering.',
                'price' => $faker->randomFloat(2, 200, 1800),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        $ramModels = [
            'Corsair Vengeance 32GB DDR5 6000MHz', 'G.Skill Trident Z5 32GB DDR5 6400MHz',
            'Kingston Fury Beast 32GB DDR5 5600MHz', 'Corsair Dominator 64GB DDR5 6200MHz',
            'G.Skill Ripjaws S5 32GB DDR5 6000MHz', 'Kingston Fury Renegade 32GB DDR5 6400MHz',
            'Corsair Vengeance 16GB DDR4 3200MHz', 'G.Skill Trident Z 32GB DDR4 3600MHz',
            'Kingston Fury Beast 16GB DDR4 3200MHz', 'Corsair Vengeance RGB 32GB DDR4 3600MHz',
            'G.Skill Ripjaws V 16GB DDR4 3200MHz', 'Kingston HyperX 16GB DDR4 3200MHz',
            'Corsair Vengeance LPX 32GB DDR4 3200MHz', 'G.Skill Trident Z Neo 32GB DDR4 3600MHz',
            'Kingston Fury Impact 32GB DDR5 5600MHz', 'Corsair Vengeance 64GB DDR5 5600MHz',
            'G.Skill Flare X5 32GB DDR5 6000MHz', 'Kingston Fury Beast 64GB DDR5 5200MHz',
            'Corsair Dominator Platinum 32GB DDR4 3600MHz', 'G.Skill Trident Z Royal 32GB DDR4 3600MHz'
        ];

        foreach ($ramModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $ramCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' High performance memory, tested and stable.',
                'price' => $faker->randomFloat(2, 50, 400),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        $mouseModels = [
            'Logitech MX Master 3S', 'Razer DeathAdder V3', 'Logitech G502 Hero',
            'Razer Viper V2 Pro', 'Logitech G Pro X Superlight', 'SteelSeries Rival 3',
            'Corsair Dark Core RGB Pro', 'Razer Basilisk V3', 'Logitech MX Anywhere 3',
            'Microsoft Surface Precision Mouse'
        ];

        foreach ($mouseModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $mouseCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' Ergonomic design, precise tracking.',
                'price' => $faker->randomFloat(2, 20, 150),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        $keyboardModels = [
            'Logitech MX Keys', 'Corsair K95 RGB Platinum', 'Razer BlackWidow V3',
            'Keychron K2', 'Ducky One 3', 'SteelSeries Apex Pro',
            'HyperX Alloy Origins', 'Logitech G Pro X', 'ASUS ROG Strix Scope',
            'Razer Huntsman Elite'
        ];

        foreach ($keyboardModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $keyboardCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' Mechanical switches, RGB lighting.',
                'price' => $faker->randomFloat(2, 40, 200),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        $speakersModels = [
            'Logitech Z623', 'Creative Pebble V3', 'Edifier R1280T',
            'Audioengine A2+', 'Logitech Z906', 'Razer Nommo Chroma',
            'Bose Companion 2', 'JBL Quantum Duo', 'Klipsch ProMedia 2.1',
            'Creative GigaWorks T40'
        ];

        foreach ($speakersModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $speakersCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' Clear sound, powerful bass.',
                'price' => $faker->randomFloat(2, 30, 300),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        $appleModels = [
            'iPhone 15 Pro Max 256GB', 'iPhone 15 Pro 128GB', 'iPhone 15 Plus 256GB',
            'iPhone 15 128GB', 'iPhone 14 Pro Max 512GB', 'iPhone 14 Pro 256GB',
            'iPhone 14 Plus 128GB', 'iPhone 14 128GB', 'iPhone 13 Pro 256GB',
            'iPhone 13 128GB'
        ];

        foreach ($appleModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $appleCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' Excellent condition, original box included.',
                'price' => $faker->randomFloat(2, 400, 1200),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        $googleModels = [
            'Google Pixel 8 Pro 256GB', 'Google Pixel 8 128GB', 'Google Pixel 7 Pro 256GB',
            'Google Pixel 7 128GB', 'Google Pixel 7a 128GB', 'Google Pixel 6 Pro 256GB',
            'Google Pixel 6 128GB', 'Google Pixel 6a 128GB', 'Google Pixel Fold 256GB',
            'Google Pixel 8a 128GB'
        ];

        foreach ($googleModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $googleCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' Clean Android experience, great camera.',
                'price' => $faker->randomFloat(2, 300, 900),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        $samsungModels = [
            'Samsung Galaxy S24 Ultra 512GB', 'Samsung Galaxy S24+ 256GB', 'Samsung Galaxy S24 128GB',
            'Samsung Galaxy S23 Ultra 512GB', 'Samsung Galaxy S23 256GB', 'Samsung Galaxy Z Fold 5 512GB',
            'Samsung Galaxy Z Flip 5 256GB', 'Samsung Galaxy A54 128GB', 'Samsung Galaxy A34 128GB',
            'Samsung Galaxy S22 Ultra 256GB'
        ];

        foreach ($samsungModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $samsungCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' Premium Samsung device, excellent display.',
                'price' => $faker->randomFloat(2, 250, 1100),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        $xiaomiModels = [
            'Xiaomi 14 Pro 512GB', 'Xiaomi 14 256GB', 'Xiaomi 13T Pro 256GB',
            'Xiaomi 13T 128GB', 'Xiaomi Redmi Note 13 Pro 256GB', 'Xiaomi Redmi Note 13 128GB',
            'Xiaomi 13 Pro 256GB', 'Xiaomi 13 128GB', 'Xiaomi Redmi 12 128GB',
            'Xiaomi Poco X6 Pro 256GB'
        ];

        foreach ($xiaomiModels as $model) {
            Listing::create([
                'user_id' => $customer->id,
                'category_id' => $xiaomiCategory->id,
                'title' => $model,
                'description' => $faker->text(150) . ' Great value for money, fast performance.',
                'price' => $faker->randomFloat(2, 150, 700),
                'condition' => $faker->randomElement(['new', 'used']),
                'contact_phone' => '+3816' . $faker->numberBetween(0, 9) . $faker->randomNumber(7, true),
                'location' => $faker->randomElement($cities),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }
    }
}
