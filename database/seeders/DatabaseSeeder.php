<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         User::factory()->create([
             'name' => 'Test Customer',
             'email' => 'customer@example.com',
             'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
         ]);

        User::factory()->create([
            'name' => 'Test Restaurant Owner',
            'email' => 'owner@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        Restaurant::factory()->create([
            'name' => 'Test Restaurant',
            'owner_id' => 2,
            'address' => '123 Test Street',
            'description' => 'This is a test restaurant.',
        ]);

        Menu::factory()->create([
            'name' => 'Test Menu Item',
            'restaurant_id' => 1,
            'description' => 'This is a test menu item.',
            'price' => 1000,
        ]);

        Menu::factory()->create([
            'name' => 'Test Menu Item 2',
            'restaurant_id' => 1,
            'description' => 'This is a test menu item 2.',
            'price' => 2000,
        ]);



    }
}
