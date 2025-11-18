<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    private $favorite;

    private $category;

    private $prefecture;

    public function __construct(Favorite $favorite, Category $category, Prefecture $prefecture)
    {
        $this->favorite = $favorite;
        $this->category = $category;
        $this->prefecture = $prefecture;
    }

    public function store($post_id)
    {
        $this->favorite->user_id = Auth::user()->id;
        $this->favorite->post_id = $post_id;
        $this->favorite->save();
        $post_id = Post::findOrfail($post_id);

        return response()->json([
            'success' => true,
            'favorited' => true,
        ]);
    }

    public function destroy($post_id)
    {
        $this->favorite->where('user_id', Auth::user()->id)
            ->where('post_id', $post_id)
            ->delete();
        $post_id = Post::findOrFail($post_id);

        return response()->json([
            'success' => true,
            'favorited' => false,
        ]);
    }

    public function show(Request $request)
    {

        $user_id = Auth::user()->id;

        // default order newest
        $order = $request->get('order', 'newest');

        // search
        $search = $request->get('search');
        $prefecture_id = $request->get('prefecture');
        $category_id = $request->get('category');

        $favorites = $this->favorite
            ->select('favorites.*')
            ->join('posts', 'favorites.post_id', '=', 'posts.id')
            ->with(['post' => function ($q) {
                $q->with(['categories'])
                    ->withCount('likes');
            }])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('posts.title', 'like', "%{$search}%")
                        ->orWhere('posts.content', 'like', "%{$search}%");
                });
            })
            ->when($prefecture_id, fn ($q) => $q->where('posts.prefecture_id', $prefecture_id))
            ->when($category_id, function ($q) use ($category_id) {
                $q->whereExists(function ($sub) use ($category_id) {
                    $sub->selectRaw(1)
                        ->from('category_posts')
                        ->whereColumn('category_posts.post_id', 'posts.id')
                        ->where('category_posts.category_id', $category_id);
                });
            })
            ->addSelect([
                'likes_count' => \DB::table('likes')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('likes.post_id', 'posts.id'),
            ])
            ->when($order === 'most_liked', fn ($q) => $q->orderByDesc('likes_count'))
            ->when($order === 'oldest', fn ($q) => $q->orderBy('posts.visited_at', 'asc'))
            ->when($order === 'newest', fn ($q) => $q->orderBy('posts.visited_at', 'desc'))
            ->where('favorites.user_id', $user_id)
            ->paginate(6);

        $all_categories = $this->category->all();
        $all_prefectures = $this->prefecture->all();

        return view('favorite.index')->with('favorites', $favorites)
            ->with('all_prefectures', $all_prefectures)
            ->with('all_categories', $all_categories)
            ->with('order', $order)
            ->with('search', $search)
            ->with('prefecture_id', $prefecture_id)
            ->with('category_id', $category_id);
    }
}
