<?php

namespace App\Services\Contracts;

use App\Models\Website;

interface WebsiteServiceInterface
{

	/**
	 * create user information
	 * 
	 * @param array data
	 * 
	 */
	public function create(array $data): ?Website;

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
	public function findById(int $id): ?Website;
}