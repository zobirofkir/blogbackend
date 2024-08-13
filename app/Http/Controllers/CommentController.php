<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('blog')->get();
        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, $blogSlug)
    {
        $user = Auth::user();
        $blog = Blog::where('slug', $blogSlug)->firstOrFail();

        $comment = Comment::create([
            'content' => $request->validated()['content'],
            'user_id' => $user->id,
            'blog_id' => $blog->id
        ]);

        return CommentResource::make($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $comment = Comment::with('blog')->findOrFail($id);
        return CommentResource::make($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment): CommentResource
    {         
        $comment->update(
            $request->validated()
        );
        return CommentResource::make(
            $comment->refresh()
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        return $comment->delete();
    }
}
