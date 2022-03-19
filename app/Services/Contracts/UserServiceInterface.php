<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserServiceInterface
{

	/**
	 * create user information
	 * 
	 * @param array data
	 * 
	 */
	public function create(array $data);

	/**
	 * get all users
	 * 
	 */
	public function all();

	/**
	 * get user by Id
	 *  @param int id
	 * 
	 */
	public function findById(int $id): ?User;
}
