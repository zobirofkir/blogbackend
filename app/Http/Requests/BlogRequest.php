<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $blogId = $this->route('blog'); // Get the blog ID from the route if it exists

        return [
            'title' => 'required|string',
            'image' => 'required|string',
            'description' => 'required|string',
            'slug' => [
                'required',
                'string',
                Rule::unique('blogs', 'slug')->ignore($blogId)
            ],
        ];
    }
}
