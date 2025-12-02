<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Category;
use App\Models\Follow;
use App\Models\Post;
use App\Models\Prefecture;
use App\Models\ProfileVisit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $user;

    private $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;

    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        $visitor = Auth::user();

        if ($visitor && $visitor->id !== $user->id) {
            $alreadyVisited = ProfileVisit::where('profile_user_id', $user->id)
                ->where('visitor_user_id', $visitor->id)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if (! $alreadyVisited) {
                ProfileVisit::create([
                    'profile_user_id' => $user->id,
                    'visitor_user_id' => $visitor->id,
                ]);
            }
        } elseif (! Auth::check()) {
            ProfileVisit::create([
                'profile_user_id' => $user->id,
                'visitor_user_id' => null,
            ]);
        }

        $posts = $this->post->where('user_id', $user->id)
            ->with(['images'])
            ->latest()
            ->get();

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

        return view('users.profile.show')
            ->with('user', $user)
            ->with('prefectures', $prefectures)
            ->with('posts', $posts)
            ->with('earnedBadges', $earnedBadges)
            ->with('notEarnedBadges', $notEarnedBadges)
            ->with('allBadges', $allBadges)
            ->with('earnedBadgeIds', $earnedBadgeIds)
            ->with('latestBadge', $latestBadge);

    }

    public function edit()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        $countries = countries();
        $categories = Category::all();

        return view('users.profile.edit')
            ->with('user', $user)
            ->with('countries', $countries)
            ->with('categories', $categories);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:100',
            'country' => 'required|max:100',
            'introduction' => 'max:100',
            'avatar' => 'mimes:jpg,jpeg,png,gif|max:1048',
            'category' => 'nullable|array|max:3',
            'category.*' => 'exists:categories,id',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = $this->user->findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->introduction = $request->introduction;
        $user->categories()->sync($request->category ?? []);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $path = $request->file('avatar')->store('avatars', 'public');

            $user->avatar = '/storage/'.$path;
        }

        if ($request->filled('password')) {
            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.show', $id);

    }

    public function followers($id, Request $request)
    {
        $user = $this->user->findOrFail($id);
        $followController = new FollowController(new Follow, new Post, new User);
        $suggested_users = $followController->getSuggestedUsers();

        $activeTab = $request->get('tab', 'followers');

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
                'suggested_users' => $suggested_users,
                'activeTab' => $activeTab,
                'prefectures' => $prefectures,
                'allBadges' => $allBadges,
                'earnedBadges' => $earnedBadges,
                'earnedBadgeIds' => $earnedBadgeIds,
                'latestBadge' => $latestBadge,
                'notEarnedBadges' => $notEarnedBadges,
            ]);
            
        }

    public function following($id, Request $request)
    {
        $user = $this->user->findOrFail($id);
        $followController = new FollowController(new Follow, new Post, new User);
        $suggested_users = $followController->getSuggestedUsers();

        $activeTab = $request->get('tab', 'following');

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
            'suggested_users' => $suggested_users,
            'activeTab' => $activeTab,
            'prefectures' => $prefectures,
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
