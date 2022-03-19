<?php

namespace App\Services\Contracts;

use App\Models\Website;

interface WebsiteServiceInterface
{

	/**
	 * create website information
	 * 
	 * @param array data
	 * 
	 */
	public function create(array $data): ?Website;

	/**
	 * get website users
	 * 
	 */
	public function all();

	/**
	 * get website by Id
	 *  @param int id
	 * 
	 */
	public function findById(int $id): ?Website;
}