<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    // private $category;

    // private $post;

    // public function __construct(Category $category, Post $post)
    // {
    //     $this->category = $category;
    //     $this->post = $post;
    // }

    // public function index()
    // {
    //     $all_categories = $this->category->orderBy('id', 'asc')->paginate(5);

    //     $all_posts = $this->post->with('categoryPost')->get();

    //     $uncategorised_count = 0;
    //     foreach ($all_posts as $post) {
    //         if ($post->categoryPost()->count() == 0) {
    //             $uncategorised_count++;
    //         }
    //     }

    //     return view('admin.categories.index', compact('all_categories', 'uncategorised_count'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:50',
    //     ]);

    //     $new_category = new Category;
    //     $new_category->name = $request->name;
    //     $new_category->save();

    //     return redirect()->back();
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:50',
    //     ]);

    //     $category = $this->category->findOrFail($id);
    //     $category->name = $request->name;
    //     $category->save();

    //     return redirect()->back();
    // }

    // public function delete($id)
    // {
    //     $category = $this->category->findOrFail($id);
    //     $category->delete();

    //     return redirect()->back();

    // }

    // public function c_RankShow($id)
    // {
    //     $cagtegory = Category::findOrFail($id);
    //     $posts = Post::where('category_id', $id)->latest()->paginate(10);

    //     return view('users.posts.c-rank');
    // }
}
