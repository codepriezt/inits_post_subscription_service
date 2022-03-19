<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

use Tests\TestCase;

class UserControllerTest extends TestCase
{
	use DatabaseTransactions;

	protected $user_base_url = 'api/v1/users';


	public function testCanCreateUser()
	{
		$endpoint = $this->user_base_url;
		$data = [
			"first_name" => "koladed",
			"last_name" => "degtf",
			"email" => "test@gmail.com",
		];

		$response = $this->post($endpoint, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
	}

	public function testCanCreateUserFailsWithWrongEmail()
	{
		$endpoint = $this->user_base_url;
		$data = [
			"first_name" => "koladed",
			"last_name" => "degtf",
			"email" => "testcom",
		];
		$this->post($endpoint, $data, [])
			->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
	}



	public function testCanFetchAllUsers()
	{
		$endpoint = $this->user_base_url;

		$data = [
			"first_name" => "koladed",
			"last_name" => "degtf",
			"email" => "test124@gmail.com",
		];

		$this->post($endpoint, $data, [])
			->assertStatus(Response::HTTP_CREATED);

		$response = $this->call('GET', $endpoint);
		$this->assertEquals(Response::HTTP_OK, $response->status());
		$response->assertSeeText("firstName", "Koladed");
		$response->assertSeeText("lastName", "Degtf");
	}

	public function testCanFetchUserById()
	{
		$endpoint = $this->user_base_url;

		$data = [
			"first_name" => "koladed",
			"last_name" => "degtf",
			"email" => "test124@gmail.com",
		];

		$response = $this->post($endpoint, $data, [])
        ->assertStatus(Response::HTTP_CREATED);

		$customer = json_decode($response->getContent())->data;
		
		$response = $this->call('GET', $endpoint.'/'.$customer->id);

		$this->assertEquals(Response::HTTP_OK, $response->status());

		$response->assertSeeText("firstName", "Koladed");
		$response->assertSeeText("lastName", "Degtf");
	}
}
