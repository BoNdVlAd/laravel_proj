<?php

use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;

function getLinks($browser)
{
    $browser->visit('https://www.mcdonalds.com')
        ->click('div.cmp-global-header__primary-nav > div > nav > ul > li:nth-child(1) > button')
        ->click('#desktop-nav-1498826098 > div > div > div.view-full-menu.d-none.d-lg-block > a')
        ->screenshot('clicked');
    $menuItems = $browser->elements('#maincatcontent > div.product-category.aem-GridColumn--default--9.aem-GridColumn > ul > li');

    $dishesLinks = [];
    foreach ($menuItems as $item) {
        $link = $item->findElement(WebDriverBy::cssSelector('a.cmp-category__item-link'));
        $image_url = $link->getAttribute('href');
        array_push($dishesLinks, $image_url);
    }
    return $dishesLinks;
}
