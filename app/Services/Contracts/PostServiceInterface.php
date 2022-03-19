<?php

namespace App\Services\Contracts;



interface PostServiceInterface
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
	 * update a user
	 * 
	 */
	public function update($id, array $data);

	/**
	 * send post to subscribers
	 * 
	 */
	public function sendPostToUsers();
}
