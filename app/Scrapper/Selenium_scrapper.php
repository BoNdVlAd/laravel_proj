<?php
namespace App\Scrapper;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class Selenium_scrapper extends GetInfoFromDish
{
    /**
     * @return void
     */
    public function testGoogleScreenshot(): void
    {
        $host = 'http://selenium:4444/wd/hub';
        $options = new ChromeOptions();
        $options->addArguments(['--disable-gpu', '--no-sandbox', '--window-size=1920,1080']);
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
        $driver = RemoteWebDriver::create($host, $capabilities);

        $getInfoFromDish = new GetInfoFromDish();

        $dishesLinks = $getInfoFromDish->getLinks($driver);

        foreach ($dishesLinks as $link) {
            $driver->get("https://www.mcdonalds.com/$link");
            sleep(1);

            $parentItem = $driver->findElement(WebDriverBy::cssSelector(env('PARENT_DIV')));

            $driver->findElement(WebDriverBy::cssSelector(env('DISH_NUTRITION_BUTTON')))->click();
            $driver->findElement(WebDriverBy::cssSelector(env('DISH_DESCRIPTION_BUTTON')))->click();

            $title = $getInfoFromDish->getTitle($parentItem);
            $img_url = $getInfoFromDish->getImgUrl($parentItem);
            $shortDescription = $getInfoFromDish->getShortDescription($parentItem);
            $description = $getInfoFromDish->getDescription($driver);
            $weight = $getInfoFromDish->getWeight($parentItem);
            $calories = $getInfoFromDish->getCalories($parentItem);
            $nutritional_value = $getInfoFromDish->getNutritionValue($driver);

            echo "\033[32mget dish: $title \033[0m\n";

            $getInfoFromDish->createDish($title, $img_url, $shortDescription, $description, $weight, $calories, $nutritional_value);
        }
        $driver->quit();
    }
}
