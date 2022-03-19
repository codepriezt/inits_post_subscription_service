<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\PostCreateRequest;
use App\Http\Resources\PostResource;
use App\Services\Contracts\PostServiceInterface;
use App\Traits\ResponseTrait;

class PostController extends Controller
{
	use ResponseTrait;

	protected $postService;

	public function __construct(PostServiceInterface $service)
	{
		$this->postService = $service;
	}


	public function create(PostCreateRequest $request)
	{
		$data = $request->validated();

		try {

			$post = $this->postService->create($data);
			return $this->sendApiResponse(Response::HTTP_CREATED, __('messages.posts_created'), new PostResource($post));
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __('messages.error_occurred'));
		}
	}

	public function all()
	{

		try {
			$posts = $this->postService->all();
			$data = [
				"posts" => PostResource::collection($posts)
			];
			return $this->sendApiResponse(Response::HTTP_OK, __('messages.posts_fetched_successfully'), $data);
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __());
		}
	}
}
