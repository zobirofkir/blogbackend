<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'blog' => new BlogResource($this->whenLoaded('blog')), // Include blog data
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
