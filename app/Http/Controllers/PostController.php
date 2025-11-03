<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::with('categories', 'user')->latest()->get();

        return view('home', compact('posts'));
    }

    public function create()
    {
        $all_categories = Category::all();
        $prefectures = Prefecture::all();

        return view('users.posts.create', compact('all_categories', 'prefectures'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'date' => 'required|date',
            'time_hour' => 'required|min:0|max:23',
            'time_min' => 'required|min:0|max:59',
            'category' => 'required|array|max:3',
            'category.*' => 'nullable|integer|exists:categories,id',
            'prefecture_id' => 'required|integer|exists:prefectures,id',
            'cost' => 'nullable|integer|min:0|max:10000',
            'image' => 'nullable',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $visitedAt = $validated['date'].' '.
            str_pad($validated['time_hour'], 2, '0', STR_PAD_LEFT).':'.
            str_pad($validated['time_min'], 2, '0', STR_PAD_LEFT).':00';

        if ($request->hasFile('image')) {
            $base64Images = [];
            foreach ($request->file('image') as $image) {
                $base64Images[] = base64_encode(file_get_contents($image));
            }
            $validated['image'] = $base64Images;
        }

        $post = new Post([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'prefecture_id' => $validated['prefecture_id'],
            'visited_at' => $visitedAt,
            'cost' => $validated['cost'] ?? 0,
            'image' => $base64Images,
            'time_hour' => $validated['time_hour'],
            'time_min' => $validated['time_min'],
        ]);

        $post->save();

        if (! empty($validated['category'])) {
            $post->categories()->attach(array_filter($validated['category']));
        }

        return redirect()->route('home')->with('success');
    }

    public function show($id)
    {
        $post = Post::with('categories', 'user', 'comments.user')->findOrFail($id);

        return view('users.posts.show', compact('post'));

    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('posts.index')->with('error');
        }

        $all_categories = Category::all();
        $prefectures = Prefecture::all();
        $selected_categories = $post->categories->pluck('id')->toArray();

        return view('users.posts.edit', compact('post', 'all_categories', 'selected_categories', 'prefectures'));

    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('posts.index')->with('error');
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

        $imagePaths = is_string($post->image) ? json_decode($post->image, true) : $post->image;
        $imagePaths = $imagePaths ?? [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('image', 'public');
                    $imagePaths[] = $path;
                }
            }
            // 最大3枚に制限
            $imagePaths = array_slice($imagePaths, 0, 3);
        }

        $visitedAt = $validated['date'].' '.
            str_pad($validated['time_hour'], 2, '0', STR_PAD_LEFT).':'.
            str_pad($validated['time_min'], 2, '0', STR_PAD_LEFT).':00';

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'prefecture_id' => $validated['prefecture_id'],
            'visited_at' => $visitedAt,
            'cost' => $validated['cost'] ?? 0,
            'image' => ($imagePaths),
        ]);

        if (! empty($validated['category'])) {
            $post->categories()->sync(array_filter($validated['category']));
        }

        return redirect()->route('post.show', $post->id)->with('success');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('posts.index')->with('error');
        }

        if ($post->image) {
            foreach (json_decode($post->image, true) as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success');
    }
}
