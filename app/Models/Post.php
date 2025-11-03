<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    // ※Push前に戻す  use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'prefecture_id',
        'visited_at',
        'cost',
        'image',
        'time_hour',
        'time_min',
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_posts', 'post_id', 'category_id');
    }

    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

    // public function likes()
    // {
    //     return $this->hasMany(Like::class)->with('user');
    // }

    // public function isLiked()
    // {
    //     return $this->likes()->where('user_id', Auth::id())->exists();
    // }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', Auth::user()->id)->exists();

    }
}
