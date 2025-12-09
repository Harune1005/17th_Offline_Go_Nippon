<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillnable = [
        'key',
        'name',
        'description',
        'image_path',
        'is_active',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'badge_user')
            ->withPivot('award_at')
            ->withTimestamps();
    }
}
