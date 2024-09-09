<?php

use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;

function getShortDescription($parentItem)
{
    $shortDescriptionItem = $parentItem->findElement(WebDriverBy::cssSelector('div.cmp-product-details-main__right-rail div.cmp-product-details-main__description'));

    return $shortDescriptionItem->getText();
}
