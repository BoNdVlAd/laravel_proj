<?php

use App\Models\AllDishes;

function createDishes($title, $img_url, $shortDescription, $description, $weight, $calories, $nutritional_value)
{
    AllDishes::firstOrCreate(
        ['title'=> $title],
        [
            'title' => $title,
            'image_url' => $img_url,
            'short_description' => $shortDescription,
            'description' => $description,
            'weight' => (int)$weight,
            'calories' => (int)$calories,
            'nutritional_value' => $nutritional_value
        ]);
}
