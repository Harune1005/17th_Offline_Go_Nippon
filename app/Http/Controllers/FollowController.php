<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
    }

    public function store(Request $request, $user_id)
    {
        $this->follow->follower_id = Auth::id();
        $this->follow->following_id = $user_id;
        $this->follow->save();

        $tab = $request->input('tab');
        $returnUrl = $request->input('return_url');

        if ($returnUrl) {
            return redirect($returnUrl);
        }

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

        $tab = $request->input('tab');
        $returnUrl = $request->input('return_url');

        if ($returnUrl) {
            return redirect($returnUrl);
        }

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

        return view('followers_followings', [
            'user' => $user,
            'searchResults' => $searchResults,
            'tab' => $tab,
            'activeTab' => $tab,
            'keyword' => $keyword,
            'suggested_users' => $this->getSuggestedUsers(),
        ]);
    }
}
