<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BlogRequestTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate(User $user = null)
    {
        $user = $user ?: User::factory()->create();
        Passport::actingAs($user);
        return $user;
    }

    /**
     * Test Get Blogs
     */
    public function testGetBlogs()
    {
        $this->authenticate();
        $response = $this->get('/api/blogs');
        $response->assertStatus(200);
    }

    /**
     * Test Create Blog
     */
    public function testCreateBlog()
    {
        $user = $this->authenticate();
        $data = [
            "title" => Str::slug("Title Zobir-" . Str::random(5)),
            "image" => "path/logo.png",
            "description" => "this is the description",
            "slug" => Str::slug("cloud computing Zobir-" . Str::random(5)),
            "user_id" => $user->id
        ];
        $response = $this->post("api/blogs", $data);
        $response->assertStatus(201);
    }

    /**
     * Test Update Blog
     */
    public function testUpdateBlog()
    {
        $user = $this->authenticate();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);    
        $data = [
            "title" => Str::slug("Title Zobir-" . Str::random(5)),
            "image" => "path/logo.png",
            "description" => "this is the description",
            "slug" => Str::slug("cloud computing Zobir-" . Str::random(5))
        ];
        $response = $this->put("api/blogs/$blog->slug", $data);
        $response->assertStatus(200);
    }

    /**
     * Test Delete Blog
     */
    public function testDeleteBlog()
    {
        $user = $this->authenticate();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);
        $response = $this->delete("api/blogs/$blog->slug");
        $response->assertStatus(200);
    }
}
