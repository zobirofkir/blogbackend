<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $blogId = $this->route('blog'); // Get the blog ID from the route if it exists

        return [
            'title' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp,tiff|max:10240', // Validates image file
            'description' => 'nullable|string',
            'slug' => [
                'nullable',
                'string',
                Rule::unique('blogs', 'slug')->ignore($blogId)
            ],
        ];
    }
}