<?php

namespace Database\Seeders;

use App\Models\Movement;
use App\Models\Product;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(9)->create();

        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $users->prepend($admin);

        $products = Product::factory()
            ->count(100)
            ->create();

        $movements = Movement::factory()
            ->count(20)
            ->recycle($users)
            ->create();

        $adminMovements = Movement::factory()
            ->for($admin)
            ->create();

        $newUserMovements = Movement::factory()
            ->forUser([
                'name' => 'Test User 2',
            ])
            ->create();

        $movementsWithProducts = Movement::factory()
            ->count(20)
            ->recycle($users)
            ->hasAttached($products->random(3), ['qty' => rand(1, 100)])
            ->create();
    }
}
