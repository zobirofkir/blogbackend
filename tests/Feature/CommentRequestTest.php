<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CommentRequestTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
    }
    
    /**
     * test get Comments
     */
    public function testGetComments()
    {
        $this->authenticate();
        $user = User::factory()->create();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);
        $response = $this->get("api/blogs/$blog->slug/comments");
        $response->assertStatus(200);
    }

    /**
     * Test Create Comment
     */
    public function testCreateComment()
    {
        $this->authenticate();
        $user = User::factory()->create();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);
        $data = [
            "content" => "this is test comments"
        ];
        $response = $this->post("api/blogs/$blog->slug/comments", $data);
        $response->assertStatus(201);
    }
}
