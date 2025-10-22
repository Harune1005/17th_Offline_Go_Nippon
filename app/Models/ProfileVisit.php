<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_user_id',
        'visitor_user_id',
    ];

    public function profileUser()
    {
        return $this->belongsTo(User::class, 'profile_user_id');
    }

    public function visitor()
    {
        return $this->belongsTo(User::class, 'visitor_user_id');
    }
}
