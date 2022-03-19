<?php

namespace App\Jobs;

use App\Mail\PostCreated;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Contracts\SubscriptionServiceInterface;
use App\Services\Contracts\PostServiceInterface;
use App\Services\Contracts\UserServiceInterface;

class BroadCastPostToSubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $post;
    protected $subscriptionService, $userService, $postService;


    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SubscriptionServiceInterface $subscriptionService, UserServiceInterface $userService, PostServiceInterface $postService)
    {

        try {


            $this->subscriptionService =  $subscriptionService;
            $this->userService = $userService;
            $this->postService = $postService;


            //get users that subscribed to this websites
            $susbcribers = $this->subscriptionService->fetchSubscribers($this->post->website_id);



            //loop through the subscribers and broadcast the message to users email
            foreach ($susbcribers as  $subscriber) {
                if (!is_null($subscriber)) {
                    $user = $this->userService->findById($subscriber->user_id);

                    // send mail to user
                    Mail::to($user->email)->send(new PostCreated($this->post, $user));

                    // update post status
                    $this->postService->update($this->post->id, ["status" => "published"]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error Sending Out Post to Subscribers. Error message: {$e->getMessage()}", $e->getTrace());
        }
    }
}
