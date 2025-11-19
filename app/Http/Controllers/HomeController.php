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
        $prefectures = Prefecture::orderBy('id')->get();

        $user = Auth::user();
        $categoryIds = $user->categories()->pluck('categories.id')->toArray();

        $postsQuery = Post::with(['categories', 'prefecture', 'images'])
            ->withCount('likes');
        if($order === 'most_liked'){
            $postsQuery->orderByDesc('likes_count');
        }elseif($order === 'recommend' && !empty($categoryIds)){
            $postsQuery->withCount(['categories as relevance' => function ($q) use ($categoryIds){
                $q->whereIn('categories.id', $categoryIds);
            }])
           ->orderByDesc('relevance')
           ->orderByDesc('created_at');
        }else{ //newest
            $postsQuery->orderByDesc('created_at');
        }
        $posts = $postsQuery->paginate(30)->appends(['order' => $order]);
            // ->when($order === 'most_liked', fn ($q) => $q->orderByDesc('likes_count'))
            // ->when($order === 'recommend' && !empty($categoryIds), fn ($q) => 
            //     $q->withCount(['categories as relevance' => fn($q2) => $q2->whereIn('categories.id', $categoryIds)])
            //       ->orderByDesc('relecance')
            //       ->orderByDesc('created_at')
            // )
            // ->when($order === 'newest', fn ($q) => $q->orderByDesc('created_at'))
            // ->paginate(30)
            // ->appends(['order' => $order]);

        $categoryCounts = DB::table('category_posts')
            ->join('categories', 'category_posts.category_id', '=', 'categories.id')
            ->select('categories.id', 'categories.name', DB::raw('COUNT(category_posts.post_id) as count'))
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

        return view('home', compact('posts', 'categoryRanked', 'prefectureRanked', 'order', 'categories', 'prefectures'));
    }

    public function rankingPost(Request $request)
    {
        $order = $request->get('order', 'newest');

        $query = Post::with(['categories', 'prefecture', 'images']);

        $titleParts = [];
        $headerImage = 'images/default.jpeg';

        $prefectureSelected = false;
        $categorySelected = false;

        if ($request->filled('prefecture_id')) {
            $prefecture = Prefecture::find($request->prefecture_id);
            if ($prefecture) {
                $query->where('prefecture_id', $prefecture->id);
                $titleParts[] = $prefecture->name;

                $headerImage = $prefecture->image ?? 'images_default.jpeg';

                $prefectureSelected = true;
            }
        }

        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $query->whereHas('categories', fn ($q) => $q->where('id', $category->id));
                $titleParts[] = $category->name;
                $headerImage = $category->image ?? 'images_default.jpeg';

                $categorySelected = true;

            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
            $titleParts[] = ''.$search.'';

            if(!$prefectureSelected && !$categorySelected){
                $headerImage = 'images/nippon.jpg';
                // $randomPrefecture = Prefecture::inRandomOrder()->first();
                // $headerImage = $randomPrefecture->image ?? 'images_default.jpeg';
            }
        }

        if($prefectureSelected){
            $headerImage = $prefecture->image ?? 'images_default.jpeg';
        }


        $query->withCount(['likes', 'favorites'])
            ->when($order === 'most_liked', fn ($q) => $q->orderByDesc('likes_count'))
            ->when($order === 'recommend', fn ($q) => $q->orderByDesc('favorites_count'))
            ->when($order === 'newest', fn ($q) => $q->orderByDesc('created_at'));

        $title = implode(' × ', $titleParts) ?: 'RANKING';
        $posts = $query->get();

        return view('users.posts.rank', compact('posts', 'title', 'headerImage', 'order'));
    }
}
