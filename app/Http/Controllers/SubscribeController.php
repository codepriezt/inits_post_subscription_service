<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\SubscriberCreateRequest;
use App\Http\Resources\SubscriberResource;
use App\Services\Contracts\SubscriptionServiceInterface;
use App\Traits\ResponseTrait;

class SubscribeController extends Controller
{

	use ResponseTrait;

	protected $subscribeService;

	public function __construct(SubscriptionServiceInterface $service)
	{
		$this->subscribeService = $service;
	}


	public function create(SubscriberCreateRequest $request)
	{
		$data = $request->validated();

		try {
			$subscriber = $this->subscribeService->checkIfExists($data);

			if ($subscriber) {
				return $this->sendApiResponse(Response::HTTP_BAD_REQUEST, __('messages.subscriber_exists'));
			}


			$subscriber = $this->subscribeService->create($data);
			return $this->sendApiResponse(Response::HTTP_CREATED, __('messages.subscription_created'), new SubscriberResource($subscriber));
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __('messages.error_occurred'));
		}
	}

	public function all()
	{

		try {
			$subscriptions = $this->subscribeService->all();
			$data = [
				"subscriptions" => SubscriberResource::collection($subscriptions)
			];
			return $this->sendApiResponse(Response::HTTP_OK, __('messages.subscribers_fetched_successfully'), $data);
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __());
		}
	}
}
