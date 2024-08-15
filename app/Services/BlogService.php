<?php

namespace App\Services;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    /**
     * Prepare blog data for storing or updating.
     *
     * @param BlogRequest $request
     * @param Blog|null $blog
     * @return array
     */
    public function prepareBlogData(BlogRequest $request, Blog $blog = null): array
    {
        $blogData = $request->validated();
        $blogData['user_id'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $blogData['image'] = $request->file('image')->store('images/blogs', 'public');
        }

        $blogData['slug'] = $this->generateUniqueSlug($blogData['title'] ?? $blog->slug, $blog);

        return $blogData;
    }

    /**
     * Generate a unique slug for the blog.
     *
     * @param string $title
     * @param Blog|null $blog
     * @return string
     */
    private function generateUniqueSlug(string $title, Blog $blog = null): string
    {
        $slug = Str::slug($title);
        $existingSlugCount = Blog::where('slug', $slug)
            ->when($blog, fn($query) => $query->where('id', '!=', $blog->id))
            ->count();

        return $existingSlugCount > 0 ? "{$slug}-" . ($existingSlugCount + 1) : $slug;
    }

    /**
     * Delete the blog's image from storage.
     *
     * @param Blog $blog
     */
    public function deleteBlogImage(Blog $blog): void
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
    }
}
