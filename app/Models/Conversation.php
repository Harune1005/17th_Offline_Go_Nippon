<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user1_id',
        'user2_id',
        'last_message_id',
    ];

    // all messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    // get conversation partner method
    public function getPartner($user_id)
    {
        if ($this->user1_id === $user_id) {
            return $this->user2 ?? null;
        }

        if ($this->user2_id === $user_id) {
            return $this->user1 ?? null;
        }

        return null;
    }

    // count unread message
    public function unreadCount($user_id)
    {
        return $this->messages()
            ->where('sender_id', '!=', $user_id)
            ->whereNull('read_at')
            ->count();
    }

    public function getLastMessageTextAttribute()
    {
        if (! $this->lastMessage) {
            return null;
        }

        if ($this->lastMessage->content) {
            return $this->lastMessage->content;
        }

        if ($this->lastMessage->image_path) {
            return '[sent image]';
        }

        if ($this->lastMessage->video_path) {
            return '[sent video]';
        }

        return null;
    }
}
