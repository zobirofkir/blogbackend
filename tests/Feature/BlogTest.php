<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Get Blogs
     */
    public function testGetBlogs()
    {
        $blog = Blog::factory()->make();
        $this->assertInstanceOf(Blog::class, $blog);
    }

    /**
     * Test Create Blog
     */
    public function testCreateBlog()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);
        $this->assertDatabaseHas("blogs", $blog->toArray());
    }

    /**
     * Test Update Blog
     */
    public function testUpdateBlog()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);

        $blog->update([
            "title" => "cloud computing",
            "image" => "path/logo.png",
            "description" =>  "this is the description",
            "slug" => "this is the slug"
        ]);

        $this->assertDatabaseHas("blogs", $blog->toArray());
    }

    /**
     * Test Delete Blog
     */
    public function testDeleteBlog()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);
        $blog->delete();
        $this->assertDatabaseEmpty(Blog::class);
    }
}
