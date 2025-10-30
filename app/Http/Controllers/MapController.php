<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Prefecture;
use App\Models\User;

class MapController extends Controller
{
    protected $user;

    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function show($id)
    {
        $this->user = User::findOrFail($id);

        $prefecture_id = Post::where('user_id', $this->user->id)
            ->pluck('prefecture_id')
            ->unique();

        $prefectures = Prefecture::select('id', 'name', 'code')
            ->get()
            ->map(function ($pref) use ($prefecture_id) {
                $pref->has_post = $prefecture_id->contains($pref->id);

                return $pref;

            });

        return view('users.profile.trip-map', [
            'user' => $this->user,
            'prefectures' => $prefectures,
        ]);
    }

    public function showPost($id, $prefecture_id)
    {
        $user = User::findOrFail($id);

        $posts = Post::where('user_id', $user->id)
            ->where('prefecture_id', $prefecture_id)
            ->with(['user', 'images'])
            ->latest()
            ->get();

        return response()->json($posts);
    }

    public function getPost($id)
    {
        // get all the post
        // $all_posts = $this->post->where('user_id', $id)->distinct()->get();
        $all_posts = $this->post
            ->where('user_id', $id)
            ->whereIn('id', function ($query) use ($id) {
                $query->selectRaw('MIN(id)')
                    ->from('posts')
                    ->where('user_id', $id)
                    ->groupBy('prefecture_id');
            })
            ->get();

        // dd($all_posts);

        // roop each of the post
        $map_posts = [];
        foreach ($all_posts as $post) {
            // if($post->user->has_post){
            $map_posts[] = ['code' => $post->prefecture->code, 'has_post' => true];
            // }

        }

        // dd($map_posts)
        // get the code
        return response()->json($map_posts);
    }
}
