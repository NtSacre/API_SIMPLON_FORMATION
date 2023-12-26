<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class formationTest extends TestCase
{
    /**
     * The function tests if the route '/api/toutesformations' returns a 200 status code and a JSON
     * response.
     */
    public function test_get_all_training(): void
    {
        //Testing route http://127.0.0.1:8000/api/toutesformations in Get 
        $response = $this->get(url('/api/toutesformations'));
//Standing  200 (ok) response
        $response->assertStatus(200);
//Standing  200 (ok) response

        $response->assertHeader('Content-Type', 'application/json');
    }
     
}
