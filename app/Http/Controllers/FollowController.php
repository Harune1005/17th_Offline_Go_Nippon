<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Follow;
use App\Models\Post;
use App\Models\Prefecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    private $follow;

    private $post;

    private $user;

    public function __construct(Follow $follow, Post $post, User $user)
    {
        $this->follow = $follow;
        $this->post = $post;
        $this->user = $user;
    }

    public function store(Request $request, $user_id)
    {
        $this->follow->follower_id = Auth::id();
        $this->follow->following_id = $user_id;
        $this->follow->save();

        if ($request->has('return_url')) {
            return redirect($request->input('return_url'));
        }

        $tab = $request->input('tab');
        $currentUser = Auth::user();

        if ($tab === 'following') {
            return redirect()->route('profile.following', $currentUser->id);
        } elseif ($tab === 'followers') {
            return redirect()->route('profile.followers', $currentUser->id);
        }

        return redirect()->route('profile.show', $user_id);
    }

    public function destroy(Request $request, $user_id)
    {
        $this->follow
            ->where('follower_id', Auth::id())
            ->where('following_id', $user_id)
            ->delete();

        if ($request->has('return_url')) {
            return redirect($request->input('return_url'));
        }

        $tab = $request->input('tab');
        $currentUser = Auth::user();

        if ($tab === 'following') {
            return redirect()->route('profile.following', $currentUser->id);
        } elseif ($tab === 'followers') {
            return redirect()->route('profile.followers', $currentUser->id);
        }

        return redirect()->route('profile.show', $user_id);
    }

    public function getSuggestedUsers()
    {
        $currentUser = Auth::user();

        $all_users = User::where('id', '!=', $currentUser->id)->get();

        $suggested_users = $all_users->filter(function ($user) use ($currentUser) {
            return ! $currentUser->isFollowing($user);
        });

        return $suggested_users;
    }

    public function search(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $tab = $request->get('tab', 'followers');
        $activeTab = $tab;
        $keyword = $request->get('search');

        if (! $keyword) {
            return redirect()->route('profile.followers', $user->id);
        }

        if ($tab === 'followers') {
            $searchResults = $user->followers()->where('name', 'like', "%{$keyword}%")->get();
        } else {
            $searchResults = $user->following()->where('name', 'like', "%{$keyword}%")->get();
        }

        $suggested_users = $this->getSuggestedUsers();
        $prefecture_ids = Post::where('user_id', $user->id)
            ->pluck('prefecture_id')
            ->unique();

        $prefectures = Prefecture::select('id', 'name', 'code')
            ->get()
            ->map(function ($pref) use ($prefecture_ids) {
                $pref->has_post = $prefecture_ids->contains($pref->id);

                return $pref;
            });
        $allBadges = Badge::all();
        $earnedBadges = $user->badges()->get();
        $earnedBadgeIds = $earnedBadges->pluck('id')->toArray();
        $latestBadge = $user->badges()->orderBy('badge_user.awarded_at', 'desc')->first();
        $notEarnedBadges = Badge::whereNotIn('id', $earnedBadges->pluck('id'))->get();

        return view('users.profile.followers_followings', [
            'user' => $user,
            'searchResults' => $searchResults,
            'tab' => $tab,
            'activeTab' => $tab,
            'keyword' => $keyword,
            'prefectures' => $prefectures,
            'suggested_users' => $this->getSuggestedUsers(),
            'allBadges' => $allBadges,
            'earnedBadges' => $earnedBadges,
            'earnedBadgeIds' => $earnedBadgeIds,
            'latestBadge' => $latestBadge,
            'notEarnedBadges' => $notEarnedBadges,
        ]);
    }

    public function showPref($id)
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
        $all_posts = $this->post
            ->where('user_id', $id)
            ->whereIn('id', function ($query) use ($id) {
                $query->selectRaw('MIN(id)')
                    ->from('posts')
                    ->where('user_id', $id)
                    ->groupBy('prefecture_id');
            })
            ->get();
        // roop each of the post
        $map_posts = [];
        foreach ($all_posts as $post) {
            $map_posts[] = ['code' => $post->prefecture->code, 'has_post' => true];

        }

        return response()->json($map_posts);
    }
}
