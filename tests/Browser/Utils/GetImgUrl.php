<?php

use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;

function getImgUrl($parentItem)
{
    $imgItem = $parentItem->findElement(WebDriverBy::cssSelector('div.cmp-product-details-main__images div.s7responsiveContainer > img'));

    return $imgItem->getAttribute('src');
}
