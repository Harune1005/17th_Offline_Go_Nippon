<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

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

    public function user(){
        return $this->belongsTo(User::class);   
    }

    public function prefecture(){
        return $this->belongsTo(Prefecture::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'category_posts','post_id','category_id');
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function isFavorited(){
        return $this->favorites()->where('user_id', 2)->exists();
                                    // 'user_id',Auth::user()->id
    }


}
