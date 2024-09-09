<?php

use Facebook\WebDriver\WebDriverBy;

function getWeight($parentItem)
{
    $titleWeightCalories = $parentItem->findElement(WebDriverBy::cssSelector('div.cmp-product-details-main__desktop-only'));
    $weight_calories = explode("|",explode("\n", $titleWeightCalories->getText())[1]);

    $weight = explode(" ", $weight_calories[0])[0];

    return $weight;
}
