<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'category_user');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class,'category_posts','category_id','post_id');
    }
}
