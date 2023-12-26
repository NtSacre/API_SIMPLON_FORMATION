<?php

namespace Tests\Feature;

use App\Models\Formation;
use App\Models\Formation_user;

use App\Models\Role;
use Tests\TestCase;
use App\Models\User;
use Carbon\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class CandidatureTest extends TestCase
{
  use RefreshDatabase;
    
    /**
     * The function `test_listeCandidat` tests the GET request to the `/api/listeCandidat` route and
     * expects a 200 (OK) response.
     */
    public function test__get_list_of_Candidat(): void
    {
       // Creating admin role
       $role = Role::factory()->create();
       
          // Creating fictif user admin
          $user = User::factory()->create();

          // Authentification's user admin
          $this->actingAs($user, 'api');
  
          // test of route http://127.0.0.1:8000/api/listeCandidat in Get 
          $response = $this->get(url('/api/listeCandidat'));
  
          // Standing  200 (OK) response
          $response->assertStatus(200);
          
    }
  




     /**
      * The function tests the list of candidates by creating a role, a fictional administrator,
      * generating a JWT token for the administrator, and using the token to authenticate the
      * administrator for accessing the list of candidates.
      */
     public function test_get_list_candidat(){
         // Create role admin
         $role = Role::factory()->create();
      // Authentification's user admin
      $user = User::factory()->create();

       // Authotification with JWT
       $token = auth('api')->login($user);

       //Using JWT token
       $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->get(url('/api/listeCandidat'));
       // (code d'état HTTP 200 OK)
       $response->assertStatus(200);
    }

    /**
     * This function tests the process of submitting a job application for a specific formation using a
     * JWT token for authentication.
     */
    public function test_make_candidature(){

      // Création d'un des role
     
      $roleCandidat = Role::factory()->candidat()->create();
 
   $userCandidat = User::factory()->create();

Formation::factory()->create();
  // Générez un token JWT pour l'utilisateur candidat
 $token = auth('api')->login($userCandidat);
  // (code d'état HTTP 200 OK)
 $this->withHeader('Authorization', 'Bearer ' . $token)
  ->post('api/candidater-formations/1')
  ->assertStatus(201)
  ->assertHeader('Content-Type','application/json');
    
   }

   /**
    * This function tests the functionality of refusing a candidate's application by sending a POST
    * request to the 'refuserCandidature' API endpoint.
    */
   public function test_refuser_candidature(){

      // Création d'un des role
     
      $roleCandidat = Role::factory()->create();
 
   $userAdmin = User::factory()->create();
   Formation::factory()->create();
   $candidature= Formation_user::factory()->create();

Formation::factory()->create();
  // Générez un token JWT pour l'utilisateur candidat
 $token = auth('api')->login($userAdmin);
  // (code d'état HTTP 200 OK)
 $this->withHeader('Authorization', 'Bearer ' . $token)
  ->put('api/refuserCandidature/1')
  ->assertStatus(201)
  ->assertHeader('Content-Type','application/json');
    
   }
}




