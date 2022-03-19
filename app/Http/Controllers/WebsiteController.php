<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\WebsiteCreateRequest;
use App\Http\Resources\WebsiteResource;
use App\Services\Contracts\WebsiteServiceInterface;
use App\Traits\ResponseTrait;

class WebsiteController extends Controller
{

	use ResponseTrait;

	protected websiteServiceInterface $WebsiteService;

	public function __construct(websiteServiceInterface $service)
	{
		$this->websiteService = $service;
	}


	public function create(WebsiteCreateRequest $request)
	{
		$data = $request->validated();

		try {
			$website = $this->websiteService->create($data);
			return $this->sendApiResponse(Response::HTTP_CREATED, __('messages.website_created'), new WebsiteResource($website));
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __('messages.error_occurred'));
		}
	}



	public function all()
	{

		try {
			$websites = $this->websiteService->all();
			$data = [
				"Websites" =>  WebsiteResource::collection($websites)
			];
			return $this->sendApiResponse(Response::HTTP_OK, __('messages.websites_fetched_successfully'), $data);
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __('messages.error_occurred'));
		}
	}


	public function findById($websiteId)
	{

		try {
			$website = $this->websiteService->findById($websiteId);
			return $this->sendApiResponse(Response::HTTP_OK, __('messages.website_fetched_successfully'), new WebsiteResource($website));
		} catch (\Exception $e) {
			$this->Exception($e);
			return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, __('messages.error_occurred'));
		}
	}
}
