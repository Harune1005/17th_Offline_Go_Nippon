<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
    }

    public function store($user_id){
        $this->follow->follower_id  = Auth::user()->id;
        $this->follow->following_id = $user_id;
        $this->follow->save();

        return redirect()->back();
    }

    public function destroy($user_id){
        $this->follow
            ->where('follower_id', Auth::user()->id)
            ->where('following_id', $user_id)
            ->delete();
        return redirect()->back();
    }

   public function getSuggestedUsers()
    {
        $currentUser = Auth::user();

        $all_users = User::where('id', '!=', $currentUser->id)->get();

        $suggested_users = $all_users->filter(function ($user) use ($currentUser) {
            return !$currentUser->isFollowing($user);
        });

        return $suggested_users;
    }


}
