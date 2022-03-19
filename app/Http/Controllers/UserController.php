<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Services\Contracts\UserServiceInterface;
use App\Traits\ResponseTrait;

class UserController extends Controller
{

	use ResponseTrait;

	protected UserServiceInterface $userService;

	public function __construct(UserServiceInterface $service)
	{
		$this->userService = $service;
	}


	public function create(UserCreateRequest $request)
	{
		$data = $request->validated();

		try {
			$user = $this->userService->create($data);
			return $this->sendApiResponse(Response::HTTP_CREATED, __('messages.user_created'), new UserResource($user));
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __('messages.error_occurred'));
		}
	}



	public function all()
	{

		try {
			$users = $this->userService->all();
			$data = [
				"users" =>  UserResource::collection($users)
			];
			return $this->sendApiResponse(Response::HTTP_OK, __('messages.users_fetched_successfully'), $data);
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __());
		}
	}


	public function findById($userId)
	{

		try {
			$user = $this->userService->findById($userId);
			return $this->sendApiResponse(Response::HTTP_OK, __('messages.user_fetched_successfully'), new UserResource($user));
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __('messages.error_occurred'));
		}
	}
}
