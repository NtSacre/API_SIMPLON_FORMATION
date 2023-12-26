<?php

namespace Tests\Feature;

use auth;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthentificationTest extends TestCase
{
    use RefreshDatabase;
   
    /**
     * The function tests the validation of a name by attempting to register a user with an invalid
     * name and expects a 422 error response.
     */
    public function test_validate_name(): void
    {
        //registing user admin
        $response = $this->post('/api/register', [
            'name' => "12345",
            'email' => fake()->email(),
            'password' => Hash::make('password'),
            'role_id' => 1,
            'address' => fake()->address(),
            'telephone' => "778529638",
        ]);
//Standing error response 422(unprocessable content)
        $response->assertStatus(422);
    }


 
    /**
     * The function tests whether an email address is unique by attempting to register two users with
     * the same email address and expecting a 422 error response.
     */
    public function test_email_be_unique(): void
    {

        // on va créer deux utilisateur avec le meme mail
        $response = $this->post('/api/register', [
            'name' => "john smith",
            'email' => "john@example.com",
            'password' => Hash::make('password'),
            'role_id' => 1,
            'address' => fake()->address(),
            'telephone' => "778529635",
        ]);
        $response = $this->post('/api/register', [
            'name' => "john doe",
            'email' => "john@example.com",
            'password' => Hash::make('password'),
            'role_id' => 1,
            'address' => fake()->address(),
            'telephone' => "778529639",
        ]);
//on s'attend à ce qu'il est une erreur 422(unprocessable content)
        $response->assertStatus(422);
    }

    /**
     * The function tests if the authentication process is working by attempting to authenticate an
     * existing user.
     */
    public function test_est_ce_que_l_authentification_marche(): void
    {

     //on Authentifie un utilisateur existant
     $response = $this->post('/api/login', [
        
        'email' => "p@gamil.com",
        'password' => 'password'
        
    ]);
      $response->assertStatus(200);
    }
}
