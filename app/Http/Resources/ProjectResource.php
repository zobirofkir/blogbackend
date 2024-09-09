<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "image" => $this->image ? asset('storage/' . $this->image) : null,
            "description" => $this->description,
            "filePath" => $this->filePath ? asset('storage/' . $this->filePath) : null,
            "slug" => $this->slug ,
            "project_url" => $this->project_url
        ];
    }
}
