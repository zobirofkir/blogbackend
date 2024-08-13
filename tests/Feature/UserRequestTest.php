<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserRequestTest extends TestCase
{
    use RefreshDatabase;
    
    private function authentucate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }
    /**
     * Test Get Users
     */
    public function testGetUsers ()
    {
        $this->authentucate();
        $response = $this->get('/api/users');
        $response->assertStatus(200);
    }

    /**
     * Test Create User
     */
    public function testCreateUser()
    {
        $this->authentucate();
        $data = [
            "name" => "zobir",
            "email" => "zobirofkir19@gmail.com",
            "password" => "password123@@@"
        ];
        $response = $this->post("api/users", $data);
        $response->assertStatus(201);
    }

    /**
     * Test Update User
     */
    public function testUpdateUser()
    {
        $this->authentucate();
        $user = User::factory()->create();
        $updateForm = [
            "name" => "zobir",
            "email" => "zobirofkir19@gmail.com",
            "password" => "meddalVOODOO123@@@"
        ];
        $response = $this->put("api/users/$user->id", $updateForm);
        $response->assertStatus(200);
    }

    /**
     * Test Delete User
     */
    public function testDeleteUser()
    {
        $this->authentucate();
        $user = User::factory()->create();
        $response = $this->delete("api/users/$user->id");
        $response->assertStatus(200);
    }
}
