<?php

use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;

function getTitle($parentItem)
{
    $title = $parentItem->findElement(WebDriverBy::cssSelector('div.cmp-product-details-main__right-rail span.cmp-product-details-main__heading-title'));

    return $title->getText();
}
