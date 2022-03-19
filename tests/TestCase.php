<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;


abstract class TestCase extends BaseTestCase
{
   
    use CreatesApplication;
    use DatabaseMigrations;


    public function decodeJsonResponse($content)
    {
        return json_decode($content->response->getContent());
    }
}
