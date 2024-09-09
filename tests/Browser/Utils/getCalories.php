<?php

use Facebook\WebDriver\WebDriverBy;


function getCalories($parentItem)
{
    $titleWeightCalories = $parentItem->findElement(WebDriverBy::cssSelector('div.cmp-product-details-main__desktop-only'));
    $weight_calories = explode("|",explode("\n", $titleWeightCalories->getText())[1]);

    $weight = explode(" ", $weight_calories[1])[1];

    return $weight;
}
