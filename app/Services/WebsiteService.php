<?php

namespace App\Services;

use App\Models\Website;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Contracts\WebsiteServiceInterface;


class WebsiteService implements WebsiteServiceInterface
{

	public function create($data): ?Website
	{
		try {
			DB::beginTransaction();
			$website = Website::firstOrCreate($data);
			DB::commit();
			return $website;
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error("Error creating Website. Error message: {$e->getMessage()}", $e->getTrace());
			return $e;
		}
	}

	public function all()
	{
		try {
			return Website::paginate(10);
	} catch (\Exception $e) {
			Log::error("Error fetching all Websites. Error message: {$e->getMessage()}", $e->getTrace());
			return $e;
		}
	}

	public function findById(int $id): ?Website
	{
		try {
			return Website::find($id);
		} catch (\Exception $e) {
			Log::error("Error finding user. Error message: {$e->getMessage()}", $e->getTrace());
			return [];
		}
	}
}
