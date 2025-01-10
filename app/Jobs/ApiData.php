<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class ApiData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $api = 'https://jsonplaceholder.typicode.com/posts';
        $response = Http::withOptions(['verify' => false])->get($api);

        if ($response->successful())
        {
            $item = $response->json();

            $first = array_slice($item, 0, 50);
            $second = array_slice($item, 50, 50);

            $firstExists = Post::whereBetween('id', [1, 50])->exists();

            if (!$firstExists) {
                foreach ($first as $item) {
                    Post::create([
                        'id' => $item['id'],
                        'title' => $item['title'],
                        'body' => $item['body'],
                        'user_id' => $item['userId'],
                    ]);
                }
            } else {
                $secondExists = Post::whereBetween('id', [51, 100])->exists();
                if (!$secondExists) {
                    foreach ($second as $item) {
                        Post::create([
                            'id' => $item['id'],
                            'title' => $item['title'],
                            'body' => $item['body'],
                            'user_id' => $item['userId'],
                        ]);
                    }
                }
            }

        }
    }
}
