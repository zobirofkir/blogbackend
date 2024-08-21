<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Jobs\BlogMailJob;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Display a listing of all blogs.
     */
    public function index(): AnonymousResourceCollection
    {
        return BlogResource::collection(
            Blog::orderBy('created_at', 'DESC')->get()
        );
    }

    /**
     * Display a listing of blogs for the authenticated user.
     */
    public function auth(): AnonymousResourceCollection
    {
        return BlogResource::collection(
            Blog::where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get()
        );
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(BlogRequest $request): BlogResource
    {
        $blogData = $this->blogService->prepareBlogData($request);
        $blog = Blog::create($blogData);

        // Dispatch job to send email with blog details
        BlogMailJob::dispatch($blog, Auth::user()->email);

        return new BlogResource($blog);
    }

    /**
     * Display the specified blog.
     */
    public function show(Blog $blog): BlogResource
    {
        return new BlogResource($blog);
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(BlogRequest $request, Blog $blog): BlogResource
    {
        $blogData = $this->blogService->prepareBlogData($request, $blog);
        $blog->update($blogData);

        return new BlogResource($blog->fresh());
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog): bool
    {
        $this->blogService->deleteBlogImage($blog);

        return $blog->delete();
    }
}
