<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Follow;
use App\Models\ProfileVisit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;

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

        return view('users.profile.show')->with('user', $user);
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
            'category.*' => 'exists:categories,id', // ← 実在するIDのみ
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
        $followController = new FollowController(new Follow());
        $suggested_users = $followController->getSuggestedUsers();

        $activeTab = $request->get('tab', 'followers'); // ← デフォルトはfollowers

        return view('followers_followings', compact('user', 'suggested_users', 'activeTab'));
    }

    public function following($id, Request $request)
    {
        $user = $this->user->findOrFail($id);
        $followController = new FollowController(new Follow());
        $suggested_users = $followController->getSuggestedUsers();

        $activeTab = $request->get('tab', 'following'); // ← デフォルトはfollowing

        return view('followers_followings', compact('user', 'suggested_users', 'activeTab'));
    }
}
