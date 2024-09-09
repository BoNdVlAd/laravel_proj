<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

require_once __DIR__ . '/Utils/GetLinks.php';
require_once __DIR__ . '/Utils/GetTitle.php';
require_once __DIR__ . '/Utils/GetImgUrl.php';
require_once __DIR__ . '/Utils/getShortDescription.php';
require_once __DIR__ . '/Utils/getDescription.php';
require_once __DIR__ . '/Utils/getNutritionValue.php';
require_once __DIR__ . '/Utils/getWeight.php';
require_once __DIR__ . '/Utils/getCalories.php';
require_once __DIR__ . '/Utils/createDishes.php';

class TestTest extends DuskTestCase
{

    /**
     * @return void
     * @throws \Throwable
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $dishesLinks = getLinks($browser);

            foreach ($dishesLinks as $link) {
                $browser->visit("https://www.mcdonalds.com$link")
                    ->pause(1000);
                $parentItem = $browser->element('#container-20012ecdca div.cmp-product-details-main');

                $browser->click('#accordion-29309a7a60-item-7d187854c5-button');
                $browser->click('#accordion-29309a7a60-item-9ea8a10642-button');

                $title = getTitle($parentItem);
                $img_url = getImgUrl($parentItem);
                $shortDescription = getShortDescription($parentItem);
                $description = getDescription($browser);
                $nutritional_value = getNutritionValue($browser);
                $weight = getWeight($parentItem);
                $calories = getCalories($parentItem);

                createDishes($title, $img_url, $shortDescription, $description, $weight, $calories, $nutritional_value);

            }
        });
    }
}
