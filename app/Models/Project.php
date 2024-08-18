<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "image",
        "description",
        "filePath",
        "slug",
        "user_id"
    ];

    protected static function booted()
    {
        static::creating(function ($project) {
            $slug = Str::slug($project->title);
            $count = static::where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
            $project->slug = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
