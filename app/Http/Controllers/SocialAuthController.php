<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'ログインに失敗しました。');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if (! $user) {

            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
                'country' => $request->country ?? 'Unknown',
                'password' => bcrypt(Str::random(24)),
            ]);
        }

        Auth::login($user, false);

        return redirect()->route('home')->with('success', 'ログインしました！');
    }
}
