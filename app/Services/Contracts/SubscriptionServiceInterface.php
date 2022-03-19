<?php

namespace App\Services\Contracts;

use App\Models\Subscription;

interface SubscriptionServiceInterface
{

	/**
	 * create subscription information
	 * 
	 * @param array data
	 * 
	 */
	public function all();
	public function create(array $data);
	public function checkIfExists(array $data);
	public function fetchSubscribers(int $websiteId);

}