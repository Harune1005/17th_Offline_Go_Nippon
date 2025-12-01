<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        $order = $request->get('order', 'newest');
        $categories = Category::orderBy('id')->get();
        $prefectures = Prefecture::orderBy('name')->get();

        $user = Auth::user();
        $categoryIds = $user->categories()->pluck('categories.id')->toArray();

        $postsQuery = Post::with(['categories', 'prefecture', 'images'])
            ->withCount('likes');
        if ($order === 'most_liked') {
            $postsQuery->orderByDesc('likes_count');
        } elseif ($order === 'recommend' && ! empty($categoryIds)) {
            $postsQuery->withCount(['categories as relevance' => function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            }])
                ->orderByDesc('relevance')
                ->orderByDesc('created_at');
        } elseif ($order === 'followers') {
            $followingIds = Auth::user()->following()->pluck('users.id')->toArray();
            $postsQuery->whereIn('user_id', $followingIds)
                ->orderByDesc('created_at');
        } else {
            $postsQuery->orderByDesc('created_at');
        }
        $posts = $postsQuery->paginate(30)->appends(['order' => $order]);

        $notifications = auth()->user()->notifications()->take(20)->get();

        $categoryCounts = DB::table('category_posts')
            ->join('categories', 'category_posts.category_id', '=', 'categories.id')
            ->select('categories.id', 'categories.name', 'categories.image', DB::raw('COUNT(category_posts.post_id) as count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->get();

        $categoryRanked = [];
        $currentRank = 0;
        $prevCount = null;
        foreach ($categoryCounts as $index => $item) {
            if ($item->count !== $prevCount) {
                $currentRank = $index + 1;
            }
            $categoryRanked[] = [
                'rank' => $currentRank,
                'id' => $item->id,
                'name' => $item->name,
                'count' => $item->count,
                'image' => $item->image ?? 'images/default.jpeg',
            ];
            $prevCount = $item->count;
        }
        $categoryRanked = array_slice($categoryRanked, 0, 10);

        $prefectureCounts = DB::table('posts')
            ->join('prefectures', 'posts.prefecture_id', '=', 'prefectures.id')
            ->select('prefectures.id as prefecture_id', 'prefectures.name as prefecture_name', 'prefectures.image', DB::raw('COUNT(posts.id) as count'))
            ->groupBy('prefectures.id', 'prefectures.name')
            ->orderByDesc('count')
            ->get();

        $prefectureRanked = [];
        $currentRank = 0;
        $prevCount = null;
        foreach ($prefectureCounts as $index => $item) {
            if ($item->count !== $prevCount) {
                $currentRank = $index + 1;
            }

            $prefectureModel = Prefecture::find($item->prefecture_id);

            $prefectureRanked[] = [
                'rank' => $currentRank,
                'prefecture_id' => $item->prefecture_id,
                'prefecture_name' => $item->prefecture_name,
                'count' => $item->count,
                'image' => $prefectureModel->image ?? 'images/default.jpeg',
            ];
            $prevCount = $item->count;
        }
        $prefectureRanked = array_slice($prefectureRanked, 0, 10);

        return view('home', compact('posts', 'categoryRanked', 'prefectureRanked', 'order', 'categories', 'prefectures', 'notifications'));
    }

    public function rankingPost(Request $request)
    {
        $order = $request->get('order', 'newest');

        $user = Auth::user();
        $categoryIds = $user->categories()->pluck('categories.id')->toArray();

        $query = Post::with(['categories', 'prefecture', 'images']);

        $titleParts = [];
        $headerImage = 'images/nippon.jpg';
        $prefectureSelected = false;
        $categorySelected = false;

        // 都道府県で絞り込み
        if ($request->filled('prefecture_id')) {
            $prefecture = Prefecture::find($request->prefecture_id);
            if ($prefecture) {
                $query->where('prefecture_id', $prefecture->id);
                $titleParts[] = $prefecture->name;
                $headerImage = $prefecture->image ?? 'images/default.jpeg';
                $prefectureSelected = true;
            }
        }

        // カテゴリーで絞り込み
        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $query->whereHas('categories', fn ($q) => $q->where('id', $category->id));
                $titleParts[] = $category->name;
                if (!$prefectureSelected) {
                    $headerImage = $category->image ?? 'images/default.jpeg';
                }
                $categorySelected = true;
            }
        }

        // 検索キーワードで絞り込み
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
            );
            $titleParts[] = $search;

            if (! $prefectureSelected && ! $categorySelected) {
                $headerImage = 'images/nippon.jpg';
            }
        }

        // 並び替え処理
        if ($order === 'most_liked') {
            $query->withCount('likes')->orderByDesc('likes_count');
        } elseif ($order === 'recommend' && ! empty($categoryIds)) {
            $query->withCount(['categories as relevance' => function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            }])->orderByDesc('relevance')->orderByDesc('created_at');
        } else { // newest
            $query->orderByDesc('created_at');
        }

        $title = implode(' × ', $titleParts) ?: 'RANKING';
        $posts = $query->paginate(30)->appends($request->query());

        return view('users.posts.rank', compact('posts', 'title', 'headerImage', 'order'));
    }
}
