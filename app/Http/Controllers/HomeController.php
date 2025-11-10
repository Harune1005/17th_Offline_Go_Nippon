<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Prefecture;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::with(['categories'])->latest()->get();

       $categoryCounts = DB::table('category_posts')
            ->join('categories', 'category_posts.category_id', '=', 'categories.id')
            ->select('categories.id', 'categories.name', DB::raw('COUNT(category_posts.post_id) as count')) // ✅ idを追加
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
            ];
            $prevCount = $item->count;
        }
        $categoryRanked = array_slice($categoryRanked, 0, 5);

        $prefectureCounts = DB::table('posts')
            ->join('prefectures', 'posts.prefecture_id', '=', 'prefectures.id')
            ->select('prefectures.id as prefecture_id', 'prefectures.name as prefecture_name', DB::raw('COUNT(posts.id) as count'))
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
            $prefectureRanked[] = [
                'rank' => $currentRank,
                'prefecture_id' => $item->prefecture_id,
                'prefecture_name' => $item->prefecture_name,
                'count' => $item->count,
            ];
            $prevCount = $item->count;
        }
        $prefectureRanked = array_slice($prefectureRanked, 0, 5);

        return view('home', compact('posts', 'categoryRanked', 'prefectureRanked'));
    }

    public function rankingPost(Request $request)
    {
        $query = Post::with(['categories', 'prefecture'])->latest();

        $title = '';
        $headerImage = 'images/default.jpg';

        if ($request->has('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $query->whereHas('categories', fn($q) => $q->where('id', $category->id));
                $title = $category->name;
                $headerImage = 'images/category.jpg';
            }
        }

        if ($request->has('prefecture_id')) {
            $prefecture = Prefecture::find($request->prefecture_id);
            if ($prefecture) {
                $query->where('prefecture_id', $prefecture->id);
                $title = strtoupper($prefecture->name);
                $headerImage = 'images/' . strtolower($prefecture->name) . '.jpeg';
            }
        }

        $posts = $query->get();

        return view('users.posts.rank', compact('posts', 'title', 'headerImage'));
    }
}
