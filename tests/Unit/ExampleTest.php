<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /** @test */
    public function it_can_visit_the_homepage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://localhost:3000') // URL вашего React приложения
            ->assertSee('Welcome') // Здесь можно проверять содержимое страницы
            ->screenshot('homepage'); // Можно сохранять скриншоты для отладки
        });
    }
}
