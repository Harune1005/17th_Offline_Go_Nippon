<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'path',
        'thumbnail_path',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
