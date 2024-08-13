<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * Test Get Comments
     */
    public function testGetComments()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);
        $comment = Comment::factory()->make([
            "user_id" => $user->id,
            "blog_id" => $blog->id
        ]);
        $this->assertInstanceOf(Comment::class, $comment);
    }

    /**
     * Test Create Comment
     */
    public function testCreateComment()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);
        $comment = Comment::factory()->create([
            "user_id" => $user->id,
            "blog_id" => $blog->id
        ]);
        $this->assertDatabaseHas("comments", $comment->toArray());
    }

    /**
     * Test Update Comment
     */
    public function testUpdateComment(){
        $user = User::factory()->create();
        $blog = Blog::factory()->create([
            "user_id" => $user->id
        ]);
        $comment = Comment::factory()->create([
            "user_id" => $user->id,
            "blog_id" => $blog->id
        ]);
        $comment->update([
            "content" => "test comment"
        ]);
        $this->assertDatabaseHas("users", $user->toArray());
    }
}
