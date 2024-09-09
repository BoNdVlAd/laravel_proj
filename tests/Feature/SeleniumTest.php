<?php

namespace Tests\Feature;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Tests\TestCase;

class SeleniumTest extends TestCase
{
    public function testExample()
    {
        $driver = RemoteWebDriver::create('http://selenium:4444/wd/hub', DesiredCapabilities::chrome());

        $driver->get('http://first_proj.test/api');

        $this->assertEquals('Laravel', $driver->getTitle());

        $driver->quit();
    }
}
