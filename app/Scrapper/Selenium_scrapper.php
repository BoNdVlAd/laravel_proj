<?php
namespace App\Scrapper;

//require '../../vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverWait;

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

        $geInfoFromDish = new GetInfoFromDish();

        $dishesLinks = $geInfoFromDish->getLinks($driver);

        foreach ($dishesLinks as $link) {
            $driver->get("https://www.mcdonalds.com/$link");
            sleep(1);

            $parentItem = $driver->findElement(WebDriverBy::cssSelector(env('PARENT_DIV')));

            $driver->findElement(WebDriverBy::cssSelector(env('DISH_NUTRITION_BUTTON')))->click();
            $driver->findElement(WebDriverBy::cssSelector(env('DISH_DESCRIPTION_BUTTON')))->click();

            $title = $geInfoFromDish->getTitle($parentItem);
            $img_url = $geInfoFromDish->getImgUrl($parentItem);
            $shortDescription = $geInfoFromDish->getShortDescription($parentItem);
            $description = $geInfoFromDish->getDescription($driver);
            $weight = $geInfoFromDish->getWeight($parentItem);
            $calories = $geInfoFromDish->getCalories($parentItem);
            $nutritional_value = $geInfoFromDish->getNutritionValue($driver);
            echo "\033[32mget dish: $title \033[0m\n";

            $geInfoFromDish->createDish($title, $img_url, $shortDescription, $description, $weight, $calories, $nutritional_value);
        }
        $driver->quit();
    }
}
