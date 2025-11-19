<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostView;
use App\Models\ProfileVisit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? User::first(); // Auth::user();
        $since = Carbon::now()->subDays(30);

        $postIds = $user->posts()->pluck('id');

        $views = PostView::whereIn('post_id', $postIds)
            ->where('created_at', '>=', $since);

        $viewsTotal = (clone $views)->count();
        $viewsFollowers = (clone $views)->where('is_follower', true)->count();
        $viewsNonFollowers = $viewsTotal - $viewsFollowers;

        $topViewedPosts = Post::whereIn('id', $postIds)
            ->withCount(['views' => function ($q) use ($since) {
                $q->where('created_at', '>=', $since);
            }])
            ->orderByDesc('views_count')
            ->take(3)
            ->get();

        $likes = Like::whereIn('post_id', $postIds)->where('created_at', '>=', $since)->count();
        $comments = Comment::whereIn('post_id', $postIds)->where('created_at', '>=', $since)->count();
        $saves = Favorite::whereIn('post_id', $postIds)->count();
        $interactionsTotal = $likes + $comments + $saves;

        $followerIds = $user->followers()->pluck('id')->toArray();

        $likesFromFollowers = $followerIds
            ? Like::whereIn('post_id', $postIds)
                ->where('created_at', '>=', $since)
                ->whereIn('user_id', $followerIds)
                ->count()
            : 0;

        $commentsFromFollowers = $followerIds
            ? Comment::whereIn('post_id', $postIds)
                ->where('created_at', '>=', $since)
                ->whereIn('user_id', $followerIds)
                ->count()
            : 0;

        $savesFromFollowers = $followerIds
            ? Favorite::whereIn('post_id', $postIds)
                ->whereIn('user_id', $followerIds)
                ->count()
            : 0;

        $interactionFollowers = $likesFromFollowers + $commentsFromFollowers + $savesFromFollowers;

        $interactionFollowersRate = $interactionsTotal > 0
            ? round(($interactionFollowers / $interactionsTotal) * 100, 1)
            : 0;

        $interactionNonFollowersRate = 100 - $interactionFollowersRate;

        $topInteractionPosts = Post::whereIn('id', $postIds)
            ->with(['images'])
            ->withCount(['likes', 'comments', 'saves'])
            ->orderByRaw('(likes_count + comments_count + saves_count) DESC')
            ->take(3)
            ->get();

        $followersNow = $user->followers()->count();
        $followersLastMonth = $user->followers()
            ->wherePivot('created_at', '<', Carbon::now()->subDays(30))
            ->count();
        $followersChange = $followersNow - $followersLastMonth;
        $followersPercent = $followersLastMonth > 0 ? round(($followersChange / $followersLastMonth) * 100, 1) : 0;

        $countryStats = User::select('country', DB::raw('count(*) as count'))
            ->whereIn('id', $user->followers()->pluck('id'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        $profileVisitsNow = ProfileVisit::where('profile_user_id', $user->id)
            ->where('created_at', '>=', $since)
            ->count();

        $profileVisitsLast = ProfileVisit::where('profile_user_id', $user->id)
            ->whereBetween('created_at', [
                Carbon::now()->subDays(60),
                Carbon::now()->subDays(30),
            ])
            ->count();

        $profileVisitChange = $profileVisitsLast > 0
            ? round(($profileVisitsNow - $profileVisitsLast) / $profileVisitsLast * 100, 1)
            : 100;

        return view('users.analytics.index', compact(
            'viewsTotal', 'viewsFollowers', 'viewsNonFollowers',
            'topViewedPosts', 'interactionsTotal', 'likes', 'comments', 'saves',
            'topInteractionPosts', 'followersNow', 'followersPercent', 'countryStats',
            'profileVisitsNow', 'profileVisitChange', 'interactionFollowersRate', 'interactionNonFollowersRate'
        ));
    }
}
