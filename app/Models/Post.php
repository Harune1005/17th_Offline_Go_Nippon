<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function views() {
        return $this->hasMany(PostView::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function saves() {
        return $this->hasMany(Save::class);
    }
}
