<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LikeNotification extends Notification
{
    use Queueable;

    public $liker_name;
    public $liker_avatar;
    public $post_id;
    public $post_title;

    public function __construct($liker_name, $liker_avatar, $post_id, $post_title)
    {
        $this->liker_name = $liker_name;
        $this->liker_avatar = $liker_avatar;
        $this->post_id = $post_id;
        $this->post_title = $post_title;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'liker_name'   => $this->liker_name,
            'liker_avatar' => $this->liker_avatar,
            'post_id'      => $this->post_id,
            'post_title'   => $this->post_title,
        ];
    }
}