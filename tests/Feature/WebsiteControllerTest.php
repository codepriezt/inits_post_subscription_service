<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

use Tests\TestCase;

class WebsiteControllerTest extends TestCase
{
	use DatabaseTransactions;

	protected $user_base_url = 'api/v1/websites';


	public function testCanCreateUser()
	{
		$endpoint = $this->user_base_url;
		$data = [
			"name" => "Twitter"
		];

		$response = $this->post($endpoint, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
	}

	public function testCanCreateUserFailsWithEmptyName()
	{
		$endpoint = $this->user_base_url;
		$data = [
			"name" => ""
		];
		$this->post($endpoint, $data, [])
			->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
	}


	public function testCanFetchAllUsers()
	{
		$endpoint = $this->user_base_url;

		$data = [
			"name" => "Twitter"
		];
		$this->post($endpoint, $data, [])
			->assertStatus(Response::HTTP_CREATED);

		$response = $this->call('GET', $endpoint);
		$this->assertEquals(Response::HTTP_OK, $response->status());
		$response->assertSeeText("name", "Twitter");
	}

	public function testCanFetchWebsiteById()
	{
		$endpoint = $this->user_base_url;

		$data = [
			"name" => "Twitter"
		];

		$response = $this->post($endpoint, $data, [])
			->assertStatus(Response::HTTP_CREATED);

		$website = json_decode($response->getContent())->data;
		$response = $this->call('GET', $endpoint . '/' . $website->id);
		$this->assertEquals(Response::HTTP_OK, $response->status());
		$response->assertSeeText("name", "Twitter");
	}
}
