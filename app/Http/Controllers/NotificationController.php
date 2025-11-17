<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->unreadNotifications->map(function($n) {
            return [
                'user'  => $n->data['liker_name'] ?? 'Unknown',
                'action'=> 'liked your post',
                'time'  => $n->created_at ? $n->created_at->diffForHumans() : '',
                'image' => $n->data['liker_avatar'] ?? 'https://via.placeholder.com/50',
            ];
        });

        return response()->json($notifications);
    }
}


