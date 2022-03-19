<?php

namespace Tests\Feature;

use App\Jobs\BroadCastPostToSubscribers;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Queue;

use Tests\TestCase;

class PostControllerTest extends TestCase
{
	use DatabaseTransactions;

	protected $post_base_url = '/api/v1/posts';
	protected $website_base_url = '/api/v1/websites';


	public function testCanCreatePost()
	{

		$endpoint = $this->website_base_url;
		$data = [
			"name" => "Twitter"
		];

		$response = $this->post($endpoint, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
        $website = json_decode($response->getContent())->data;

		$endpoint = $this->post_base_url;
		$data = [
			"title" => "Post one",
			"description" => "this is a wordepress",
			"website_id" => $website->id
		];

		Queue::fake();

		$response = $this->post($endpoint, $data, []);

		Queue::assertPushed(BroadCastPostToSubscribers::class);
		$response->assertStatus(Response::HTTP_CREATED);

	}


	public function testCanFetchAllPost()
	{

		$endpoint = $this->website_base_url;
		$data = [
			"name" => "Wordpress"
		];

		$response = $this->post($endpoint, $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
        $website = json_decode($response->getContent())->data;

		$postEndpoint = $this->post_base_url;
		$data = [
			"title" => "Post one",
			"description" => "this is a wordepress website",
			"website_id" => $website->id
		];


		$response = $this->post($postEndpoint , $data, []);
		$response->assertStatus(Response::HTTP_CREATED);
		
	
		$response = $this->get($postEndpoint, $data, []);
		$this->assertEquals(Response::HTTP_OK, $response->status());
	}

}
