<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

use Tests\TestCase;

class SubscribeControllerTest extends TestCase
{
	use DatabaseTransactions;

	protected $subscribe_base_url = '/api/v1/subscribe';
	protected $website_base_url = '/api/v1/websites';
	protected $user_base_url = '/api/v1/users';


	public function testCanCreateSubscription()
	{

		$endpoint = $this->user_base_url;
		$data = [
			"first_name" => "koladed",
			"last_name" => "degtf",
			"email" => "test@gmail.com",
		];

		$response = $this->post($endpoint, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
		$user = json_decode($response->getContent())->data;


		$endpoint = $this->website_base_url;
		$data = [
			"name" => "Twitter"
		];

		$response = $this->post($endpoint, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
        $website = json_decode($response->getContent())->data;



		$endpoint = $this->subscribe_base_url;

		$data = [
			"user_id" => $user->id,
			"website_id" => $website->id
		];

		$response = $this->post($endpoint, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
	}


	public function testCanFetchAllSubscription()
	{

		$endpoint = $this->user_base_url;
		$data = [
			"first_name" => "koladed",
			"last_name" => "degtf",
			"email" => "test@gmail.com",
		];

		$response = $this->post($endpoint, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
		$user = json_decode($response->getContent())->data;


		$endpointII = $this->website_base_url;
		$data = [
			"name" => "Twitter"
		];

		$response = $this->post($endpointII, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
        $website = json_decode($response->getContent())->data;



		$endpointIII = $this->subscribe_base_url;

		$data = [
			"user_id" => $user->id,
			"website_id" => $website->id
		];

		$response = $this->post($endpointIII, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
	
		$response = $this->get($endpointIII, $data, []);
		$this->assertEquals(Response::HTTP_OK, $response->status());
		$response->assertSeeText("website", $website->name);
		$response->assertSeeText("user_id", $user->id );
		$response->assertSeeText("website_id",$website->id );
	}

}

?>