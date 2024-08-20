<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\ClientBuilder;
use Exception;
use Illuminate\Console\Command;
use App\Models\Dishes;

class IndexPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:posts';

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
        $client = ClientBuilder::create()->build();
        $posts = Dishes::all();

        foreach ($posts as $post) {
            try {
                $client::index([
                    'id' => $post->id,
                    'index' => 'posts',
                    'body' => [
                        'title' => $post->title,
                        'content' => $post->content
                    ]
                ]);
            } catch (Exception $e) {
                $this->info($e->getMessage());
            }
        }

        $this->info("Posts were successfully indexed");
    }
}
