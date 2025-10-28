<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Prefecture;
use App\Models\User;

class MapController extends Controller
{
    protected $user;

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
            ->with('user')
            ->latest()
            ->get();

        return response()->json($posts);
    }
}
