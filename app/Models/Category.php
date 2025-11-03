<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post', 'category_id', 'post_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'category_user');
    }

    // public function posts()
    // {
    //     return $this->belongsToMany(Post::class, 'category_posts', 'category_id', 'post_id');
    // }
}
