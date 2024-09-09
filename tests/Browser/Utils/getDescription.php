<?php

use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;

function getDescription($browser)
{
    $descriptionItem = $browser->element('#container-306d859e3d div.cmp-view-ingredients-allergens__item');
    if ($descriptionItem) {
        $description = explode("\n", $descriptionItem->getText())[0];
        return $description;
    }
    else return '';

}
