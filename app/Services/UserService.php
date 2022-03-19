<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Contracts\UserServiceInterface;


class UserService implements UserServiceInterface
{

	public function create($data): ?User
	{
		try {
			DB::beginTransaction();
			$user = User::firstOrCreate($data);
			DB::commit();
			return $user;
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error("Error creating user. Error message: {$e->getMessage()}", $e->getTrace());
			return $e;
		}
	}

	public function all()
	{
		try {
			return User::paginate(10);
	} catch (\Exception $e) {
			Log::error("Error fetching all users. Error message: {$e->getMessage()}", $e->getTrace());
			return $e;
		}
	}

	public function findById(int $id): ?User
	{
		try {
			return User::find($id);
		} catch (\Exception $e) {
			Log::error("Error finding user. Error message: {$e->getMessage()}", $e->getTrace());
			return [];
		}
	}
}
