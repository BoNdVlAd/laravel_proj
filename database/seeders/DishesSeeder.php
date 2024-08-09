<?php

namespace Database\Seeders;

use App\Models\Dishes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DishesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        title' => fake()->city(),
//        'order_id' => $this->faker->numberBetween(1,10),

        $dish1 = new Dishes();
        $dish1->title = "Borsch";
        $dish1->description = "Very tasty";
        $dish1->price = 100;
        $dish1->save();

        $dish = Dishes::find(1);
        $gallery = $dish->gallery()->create();
        $gallery->media()->create([
            'filename' => 'borsch.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 50,
            'url' => 'http://example.com/borsch.jpg',
        ]);
    }
}
