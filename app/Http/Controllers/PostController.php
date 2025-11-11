<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * 投稿一覧ページ
     */
    public function index()
    {
        // Eager load で categories, user, images をまとめて取得
        $posts = Post::with(['categories', 'user', 'images'])->latest()->get();

        return view('home', compact('posts'));
    }

    /**
     * 投稿作成フォーム
     */
    public function create()
    {
        $all_categories = Category::all();
        $prefectures = Prefecture::all();

        return view('users.posts.create', compact('all_categories', 'prefectures'));
    }

    /**
     * 投稿保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
            'time_hour' => 'required|integer|min:0|max:23',
            'time_min' => 'required|integer|min:0|max:59',
            'category' => 'required|array|max:3',
            'category.*' => 'nullable|integer|exists:categories,id',
            'prefecture_id' => 'required|integer|exists:prefectures,id',
            'cost' => 'nullable|integer|min:0|max:10000',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 訪問日時をまとめて作成
        $visitedAt = $validated['date'].' '.
            str_pad($validated['time_hour'], 2, '0', STR_PAD_LEFT).':'.
            str_pad($validated['time_min'], 2, '0', STR_PAD_LEFT).':00';

        // 投稿作成
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'prefecture_id' => $validated['prefecture_id'],
            'visited_at' => $visitedAt,
            'cost' => $validated['cost'] ?? 0,
            'time_hour' => $validated['time_hour'],
            'time_min' => $validated['time_min'],
        ]);

        // カテゴリ紐付け
        if (! empty($validated['category'])) {
            $post->categories()->attach(array_filter($validated['category']));
        }

        // 画像保存（images テーブル）
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                if ($img->isValid()) {
                    $post->images()->create([
                        'image' => base64_encode(file_get_contents($img)),
                    ]);
                }
            }
        }

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    /**
     * 投稿詳細
     */
    public function show($id)
    {
        $post = Post::with(['categories', 'user', 'images', 'comments.user'])->findOrFail($id);

        return view('users.posts.show', compact('post'));
    }

    /**
     * 投稿編集フォーム
     */
    public function edit($id)
    {
        $post = Post::with('categories', 'images')->findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('home')->with('error', 'Unauthorized');
        }

        $all_categories = Category::all();
        $prefectures = Prefecture::all();
        $selected_categories = $post->categories->pluck('id')->toArray();

        return view('users.posts.edit', compact('post', 'all_categories', 'selected_categories', 'prefectures'));
    }

    /**
     * 投稿更新
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('home')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
            'time_hour' => 'required|integer|min:0|max:23',
            'time_min' => 'required|integer|min:0|max:59',
            'category' => 'required|array|max:3',
            'category.*' => 'nullable|integer|exists:categories,id',
            'prefecture_id' => 'required|integer|exists:prefectures,id',
            'cost' => 'nullable|integer|min:0|max:10000',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $visitedAt = $validated['date'].' '.
            str_pad($validated['time_hour'], 2, '0', STR_PAD_LEFT).':'.
            str_pad($validated['time_min'], 2, '0', STR_PAD_LEFT).':00';

        // 投稿更新
        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'prefecture_id' => $validated['prefecture_id'],
            'visited_at' => $visitedAt,
            'cost' => $validated['cost'] ?? 0,
            'time_hour' => $validated['time_hour'],
            'time_min' => $validated['time_min'],
        ]);

        // カテゴリ同期
        if (! empty($validated['category'])) {
            $post->categories()->sync(array_filter($validated['category']));
        }

        // 追加画像保存
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                if ($img->isValid()) {
                    $post->images()->create([
                        'image' => base64_encode(file_get_contents($img)),
                    ]);
                }
            }
        }

        return redirect()->route('post.show', $post->id)->with('success', 'Post updated successfully!');
    }

    /**
     * 投稿削除
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('home')->with('error', 'Unauthorized');
        }

        // images テーブルの画像は自動的に削除される場合、Post モデルに cascade 設定推奨
        $post->images()->delete();

        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully!');
    }
}
