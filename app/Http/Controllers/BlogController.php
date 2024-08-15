<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Jobs\BlogMailJob;
use App\Mail\BlogMail;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return BlogResource::collection(
            Blog::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */ 
    public function store(BlogRequest $request): BlogResource
    {
        $blogData = $request->validated();
        $blogData['user_id'] = Auth::user()->id;

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/blogs', 'public');
            $blogData['image'] = $imagePath;
        }

        $slug = Str::slug($blogData['title']);
        $existingSlugCount = Blog::where('slug', $slug)->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }

        $blogData['slug'] = $slug;

        $blog = Blog::create($blogData);

        // Send the email, pass the user's email to the job
        BlogMailJob::dispatch($blog, Auth::user()->email);

        return new BlogResource($blog);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog): BlogResource
    {
        return new BlogResource($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog): BlogResource
    {
        // Validate and extract data
        $blogData = $request->validated();    
        $slug = Str::slug($blogData['title']);
        // Ensure the slug is unique
        $existingSlugCount = Blog::where('slug', $slug)->where('id', '!=', $blog->id)->count();
        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
        $blogData['slug'] = $slug; // Set the generated slug
        // Update the blog entry
        $blog->update($blogData);
        // Return the updated blog resource
        return new BlogResource($blog->refresh());
    }
            
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog) : bool
    {

        // delete blog image from storage whe the user is delete it 
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        return $blog->delete();
    }
}
