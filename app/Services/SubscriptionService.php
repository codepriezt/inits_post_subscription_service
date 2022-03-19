<?php

namespace App\Services;

use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Contracts\SubscriptionServiceInterface;


class SubscriptionService implements SubscriptionServiceInterface
{

	public function create($data): ?Subscription
	{
		try {
			DB::beginTransaction();
			$sub = Subscription::firstOrCreate($data);
			DB::commit();
			return $sub;
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error("Error creating Subscribers. Error message: {$e->getMessage()}", $e->getTrace());
			return $e;
		}
	}

	public function all()
	{
		try {
			return Subscription::paginate(10);
	} catch (\Exception $e) {
			Log::error("Error fetching all subscription. Error message: {$e->getMessage()}", $e->getTrace());
			return $e;
		}
	}


	public function checkIfExists($data)
	{
		return Subscription::where(['user_id' => $data['user_id'] , 'website_id' => $data['website_id']])->first();
	}

}
