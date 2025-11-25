<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * 投稿一覧ページ
     */
    public function index()
    {

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
            'image' => 'required|array|max:3',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',

        ]);

        $visitedAt = $validated['date'].' '.
            str_pad($validated['time_hour'], 2, '0', STR_PAD_LEFT).':'.
            str_pad($validated['time_min'], 2, '0', STR_PAD_LEFT).':00';

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

        if (! empty($validated['category'])) {
            $post->categories()->attach(array_filter($validated['category']));
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                if ($img && $img->isValid()) {
                    $path = $img->store('images/posts', 'public');
                    $post->images()->create([
                        'image' => $path,
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

        $viewer = Auth::user();

        // Analytics viewer
        if ($viewer) {
            $alreadyViewed = PostView::where('post_id', $post->id)
                ->where('viewer_id', $viewer->id)
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if (! $alreadyViewed) {
                PostView::create([
                    'post_id' => $post->id,
                    'viewer_id' => $viewer->id,
                    'is_follower' => $post->user->followers()
                        ->where('follower_id', $viewer->id)
                        ->exists(),
                ]);
            }
        } else {

            PostView::create([
                'post_id' => $post->id,
                'viewer_id' => null,
                'is_follower' => false,
            ]);
        }

        return view('users.posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::with('categories')->findOrFail($id);
        $all_categories = Category::all();
        $prefectures = Prefecture::all();
        $selected_categories = $post->categories->pluck('id')->toArray();

        return view(
            'users.posts.edit',
            compact('post', 'all_categories', 'prefectures', 'selected_categories')
        );
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'nullable|date',
            'time_hour' => 'nullable|integer|min:0|max:23',
            'time_min' => 'nullable|integer|min:0|max:59',
            'category' => 'nullable|array|max:3',
            'category.*' => 'integer|exists:categories,id',
            'prefecture_id' => 'required|integer|exists:prefectures,id',
            'cost' => 'nullable|integer|min:0|max:10000',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'exists:images,id',
            'new_image' => 'nullable|array|max:3',
            'new_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        // 既存画像の数と削除予定の数を計算
        $currentImageCount = $post->images->count();
        $deletedCount = count($request->deleted_images ?? []);
        $remainingCount = $currentImageCount - $deletedCount;

        $newImageCount = count($request->file('new_image') ?? []);

        // 画像必須チェック
        if ($remainingCount + $newImageCount === 0) {
            return redirect()->back()->withInput()->withErrors(['new_image' => 'At least one image is required.']);
        }

        if ($remainingCount + $newImageCount > 3) {
            return redirect()->back()->withInput()->withErrors(['new_image' => 'You can have a maximum of 3 images total (current remaining + new uploads).']);
        }

        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->prefecture_id = $validated['prefecture_id'];
        $post->cost = $validated['cost'] ?? 0;
        $post->time_hour = $validated['time_hour'];
        $post->time_min = $validated['time_min'];
        $post->save();

        if (! empty($validated['date']) && isset($validated['time_hour'], $validated['time_min'])) {
            $post->visited_at = sprintf(
                '%s %02d:%02d:00',
                $validated['date'],
                $validated['time_hour'],
                $validated['time_min']
            );
            $post->save();
        }

        if (isset($validated['category'])) {
            $post->categories()->sync($validated['category']);
        } else {
            $post->categories()->detach();
        }

        // 既存画像の削除
        if ($request->has('deleted_images')) {
            $deletedImageIds = $request->deleted_images;
            $imagesToDelete = Image::whereIn('id', $deletedImageIds)->where('post_id', $post->id)->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
        }

        // 新規画像アップロード
        if ($request->hasFile('new_image')) {
            foreach ($request->file('new_image') as $newImageFile) {
                $path = $newImageFile->store('images/posts', 'public');
                $post->images()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('post.show', $post->id)
            ->with('success', 'Post updated successfully!');
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

    foreach ($post->images as $image) {
        Storage::disk('public')->delete($image->image);
        $image->delete();
    }

    $post->forceDelete();

    return redirect()->route('home')->with('success', 'Post deleted successfully!');
}

}
