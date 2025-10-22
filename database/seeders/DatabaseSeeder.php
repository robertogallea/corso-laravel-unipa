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

        // crea dei Movement senza prodotti
        $movementsWithProducts = Movement::factory()
            ->count(20)
            ->recycle($users)
            ->create();

        // per ciascun Movement
        foreach ($movements as $movement) {
            // attacco tre Product
            foreach (range(1, 3) as $index) {
                $movement->products()->attach(
                    $products->random(1),
                    ['qty' => rand(5,10)]
                );
            }
            $movement->save();
        }
    }
}
