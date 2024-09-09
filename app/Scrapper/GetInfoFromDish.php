<?php

namespace App\Scrapper;

use App\Models\AllDishes;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class GetInfoFromDish
{
    /**
     * @param $driver
     * @return array
     */
    public function getLinks($driver): array
    {
        try {
            $driver->get('https://www.mcdonalds.com');
            $driver->findElement(WebDriverBy::cssSelector(env('MENU_BUTTON')))->click();
            $driver->findElement(WebDriverBy::cssSelector(env('ALL_DISHES_BUTTON')))->click();

            $menuItems = $driver->findElements(WebDriverBy::cssSelector(env('DISHES_LINKS')));

            $dishesLinks = [];
            foreach ($menuItems as $item) {
                $link = $item->findElement(WebDriverBy::cssSelector(env('SELECTOR_LINK')));
                $dish_url = $link->getAttribute('href');

                echo "get dish link: " . $dish_url . "\n";

                $dishesLinks[] = $dish_url;
            }
            return $dishesLinks;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo "\033[31m Error: $error\033[0m\n";
            return [];
        }
    }

    /**
     * @param $parentItem
     * @return string
     */
    public function getTitle($parentItem): string
    {
        try {
            $title = $parentItem->findElement(WebDriverBy::cssSelector(env('SELECTOR_TITLE')));

            return $title->getText();
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo "\033[31m Error: $error\033[0m\n";
            return '';
        }
    }

    /**
     * @param $parentItem
     * @return string
     */
    public function getImgUrl($parentItem): string
    {
        try {
            sleep(1);
            $imgItem = $parentItem->findElement(WebDriverBy::cssSelector(env('SELECTOR_IMG')));

            return $imgItem->getAttribute('src');
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo "\033[31m Error: $error\033[0m\n";
            return '';
        }
    }

    /**
     * @param $parentItem
     * @return string
     */
    public function getShortDescription($parentItem): string
    {
        try {
            $shortDescriptionItem = $parentItem->findElement(WebDriverBy::cssSelector(env('SELECTOR_SHORT_DESCRIPTION')));

            return $shortDescriptionItem->getText();
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo "\033[31m Error: $error\033[0m\n";
            return '';
        }
    }

    /**
     * @param RemoteWebDriver $driver
     * @return string
     */
    public function getDescription(RemoteWebDriver $driver): string
    {
        try {
            $descriptionItem = $driver->findElement(WebDriverBy::cssSelector(env('SELECTOR_DESCRIPTION')));
            $description = explode("\n", $descriptionItem->getText())[0];

            return $description;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo "\033[31mError: $error \033[0m\n";
            return '';
        }
    }

    /**
     * @param $parentItem
     * @return string
     */
    public function getWeight($parentItem): string
    {
        try {
            $weightCalories = $parentItem->findElement(WebDriverBy::cssSelector(env('SELECTOR_WEIGHT_CALORIES')));
            $weight_calories = explode("|",explode("\n", $weightCalories->getText())[1]);

            $weight = explode(" ", $weight_calories[0])[0];

            return $weight;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo "\033[31m Error: $error\033[0m\n";
            return '';
        }
    }

    /**
     * @param $parentItem
     * @return string
     */
    public function getCalories($parentItem): string
    {
        try {
            $weightCalories = $parentItem->findElement(WebDriverBy::cssSelector(env('SELECTOR_WEIGHT_CALORIES')));
            $weight_calories = explode("|",explode("\n", $weightCalories->getText())[1]);

            $weight = explode(" ", $weight_calories[1])[1];

            return $weight;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo "\033[31m Error: $error\033[0m\n";
            return '';
        }
    }

    /**
     * @param $driver
     * @return array
     */
    public function getNutritionValue($driver): array
    {
        try {
            $nutritionItems = $driver->findElements(WebDriverBy::cssSelector(env('SELECTOR_NUTRITION')));

            $nutritional_value = [];

            foreach ($nutritionItems as $item) {
                $data = $item->findElement(WebDriverBy::cssSelector(env('SELECTOR_NUTRITION_ITEM')))->getText();
                array_push($nutritional_value, $data);
            }

            return $nutritional_value;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo "\033[31m Error: $error\033[0m\n";
            return [];
        }
    }

    /**
     * @param $title
     * @param $img_url
     * @param $shortDescription
     * @param $description
     * @param $weight
     * @param $calories
     * @param $nutritional_value
     * @return void
     */
    public function createDish($title, $img_url, $shortDescription, $description, $weight, $calories, $nutritional_value): void
    {
        try {
            AllDishes::updateOrCreate(
                ['title'=> $title],
                [
                    'title' => $title,
                    'image_url' => $img_url,
                    'short_description' => $shortDescription,
                    'description' => $description,
                    'weight' => (int)$weight,
                    'calories' => (int)$calories ?? 0,
                    'nutritional_value' => $nutritional_value
                ]);
            echo "\033[35mitem created: $title\033[0m\n";
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo "\033[31mError: $error\033[0m\n";
        }
    }
}
