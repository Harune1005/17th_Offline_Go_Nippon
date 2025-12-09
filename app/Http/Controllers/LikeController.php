<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Notifications\LikeNotification;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function store($post_id)
    {
        $user = Auth::user();
        $this->like->user_id = $user->id;
        $this->like->post_id = $post_id;
        $this->like->save();

        // 🔔 通知
        $post = Post::find($post_id);

        if ($post && $post->user_id !== $user->id) {

            $avatar = $user->avatar ? asset($user->avatar) : null;

            // ✔ 通知を送る（配列が正しく渡る）
            $post->user->notify(new LikeNotification(
                $user->name,
                $avatar,
                $post->id,
                $post->title,
                $post->image,
                $user->id
            ));
        }

        // return redirect()->back();
        return response()->json([
            'success' => true,
            'liked' => true,
            'like_count' => $post->likes()->count(),
        ]);

    }

    public function destroy($post_id)
    {
        $this->like
            ->where('post_id', $post_id)
            ->where('user_id', Auth::user()->id)
            ->delete();

        $post = Post::find($post_id);

        // return redirect()->back();
        return response()->json([
            'success' => true,
            'liked' => false,
            'like_count' => $post->likes()->count(),
        ]);
    }

    public function getNotifications()
    {
        $notifications = Auth::user()->unreadNotifications->map(function ($n) {
            return [
                'user' => $n->data['liker_name'],
                'action' => 'liked your post',
                'time' => $n->created_at->diffForHumans(), // 3h前、1d前など
                'image' => $n->data['liker_avatar'] ?? 'https://via.placeholder.com/50',
            ];
        });

        return response()->json($notifications);
    }
}
