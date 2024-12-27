<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'blogs';

    // Fillable properties for mass assignment
    protected $fillable = ['title', 'content', 'image'];

    // Define relationships
    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'blog_id');
    }
}
