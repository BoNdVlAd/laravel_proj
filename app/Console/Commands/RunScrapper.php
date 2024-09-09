<?php

namespace App\Console\Commands;

use App\Scrapper\Selenium_scrapper;
use Illuminate\Console\Command;

class RunScrapper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:scrapper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $scrapper = new Selenium_scrapper();
        $scrapper->testGoogleScreenshot();

        $this->info('Selenium scrapper executed successfully!');

        return Command::SUCCESS;
    }
}