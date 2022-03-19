<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Contracts\PostServiceInterface;
use App\Jobs\BroadCastPostToSubscribers;



class PostService implements PostServiceInterface
{

	public function create($data): ?Post
	{
		try {
			DB::beginTransaction();
			$post = Post::firstOrCreate($data);
			DB::commit();

			dispatch(new BroadCastPostToSubscribers($post));
			return $post;
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error("Error creating Subscribers. Error message: {$e->getMessage()}", $e->getTrace());
			return $e;
		}
	}

	public function all()
	{
		try {
			return Post::paginate(10);
		} catch (\Exception $e) {
			Log::error("Error fetching all subscription. Error message: {$e->getMessage()}", $e->getTrace());
			return $e;
		}
	}


	public function update($id, array $data)
	{
		$post = Post::find($id);

		try {
			DB::beginTransaction();
			if (!$post) {
				return false;
			}
			$post->update($data);
			DB::commit();
			Log::info("Post Updated");
		} catch (\Exception $e) {
			Log::error("Error updating post. Error message: {$e->getMessage()}", $e->getTrace());
			return $e;
		}
	}

	public function sendPostToUsers()
	{
		//get all post that are not published

		$notPublishedPost = Post::where(['status' => 'not_published'])->get();
		if (count($notPublishedPost) >= 1) {
			foreach ($notPublishedPost as $post) {
				dispatch(new BroadCastPostToSubscribers($post));
			}
		}
		Log::info("All Post Has been published");
	}
}
