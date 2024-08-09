<?php

namespace Database\Seeders;

use App\Models\Dishes;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory(5)->create();
//        Order::factory(10)->create();
//        Dishes::factory(20)->create();
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DishesSeeder::class);
    }
}
