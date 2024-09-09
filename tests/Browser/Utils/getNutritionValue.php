<?php

use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;

function getNutritionValue($browser)
{
    $nutritionItems = $browser->elements('#pdp-nutrition-summary ul.cmp-nutrition-summary__heading-primary > li');

    $nutritional_value = [];

    foreach ($nutritionItems as $item) {
        $data = $item->findElement(WebDriverBy::cssSelector('span.value > span:first-child'))->getText();
        array_push($nutritional_value, $data);
    }


    return $nutritional_value;
}
