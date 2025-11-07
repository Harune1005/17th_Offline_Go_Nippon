<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        // 仮のデータ（DBがまだない場合）
        $notifications = [
            [
                'user' => 'Test2',
                'action' => 'liked your post',
                'time' => '3h',
                'image' => 'https://via.placeholder.com/100',
            ],
            [
                'user' => 'Test3',
                'action' => 'liked your post',
                'time' => '1d',
                'image' => 'https://via.placeholder.com/100',
            ],
        ];

        return response()->json($notifications);
    }
}
