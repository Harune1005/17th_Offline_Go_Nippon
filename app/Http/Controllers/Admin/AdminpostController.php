<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Prefecture;
use Illuminate\Http\Request;

class AdminpostController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index(Request $request)
    {
        // フィルタ入力（任意）
        $selectedCategory = $request->query('category');
        $selectedPrefecture = $request->query('prefecture');

        // 選択肢用データを取得
        $categories = Category::orderBy('name')->get();
        $prefectures = Prefecture::orderBy('name')->get();

        // 投稿の基本クエリ（必要なリレーションをロード）
        $query = Post::withTrashed()
            ->with(['images', 'categoryPost.category', 'prefecture', 'user'])
            ->orderBy('id', 'asc');

        // カテゴリで絞る（post -> categoryPost -> category の構成を想定）
        if ($selectedCategory) {
            $query->whereHas('categoryPost.category', function ($q) use ($selectedCategory) {
                $q->where('id', $selectedCategory);
            });
        }

        // 都道府県で絞る（postがprefecture_idを持つ想定）
        if ($selectedPrefecture) {
            $query->where('prefecture_id', $selectedPrefecture);
        }

        $all_posts = $query->paginate(5);

        // ビューに渡す（ここで categories / prefectures を渡すのが重要！）
        return view('admin.posts.index', compact(
            'all_posts',
            'categories',
            'prefectures',
            'selectedCategory',
            'selectedPrefecture'
        ));
    }

    public function deactivate($id)
    {
        $post = $this->post->findOrFail($id);
        $post->delete();

        return redirect()->back();
    }

    public function activate($id)
    {
        $this->post->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $all_posts = $this->post->where('description', 'like', '%'.$request->search.'%')->withTrashed()->latest()->paginate(5);

        return view('admin.posts.index')
            ->with('all_posts', $all_posts)
            ->with('search', $request->search);
    }
}
