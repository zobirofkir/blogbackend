<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "title" => "nullable|string",
            "image" => "nullable|image|mimes:jpg,jpeg,png,bmp,tiff|max:10240",
            "description" => "nullable|string",
            'filePath' => 'nullable|file|mimes:zip,rar|max:102400',
            "slug" => "nullable|string"
        ];
    }
}
