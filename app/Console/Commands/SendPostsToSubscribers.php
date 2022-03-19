<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use App\Services\Contracts\PostServiceInterface;
use Illuminate\Console\Command;

class SendPostsToSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:created';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send post To users that are subscribed to a website';

    protected $postService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(PostServiceInterface $postService)
    {
        

        try {
            $this->postService = $postService;

            return $this->postService->sendPostToUsers();
        } catch (\Exception $e) {
            Log::error("Error scheduling job to users. Error message: {$e->getMessage()}", $e->getTrace());
        }
    }
}
