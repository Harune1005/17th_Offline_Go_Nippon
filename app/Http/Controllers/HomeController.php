<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

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
            ->select('categories.name', DB::raw('COUNT(category_posts.post_id) as count'))
            ->groupBy('categories.name')
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
}
