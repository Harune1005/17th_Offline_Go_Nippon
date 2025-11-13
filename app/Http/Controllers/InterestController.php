<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $user = Auth::user();

        if ($user->categories()->exists()) {
            return redirect()->route('home');
        }

        return view('interest', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array|min:1|max:3',
            'categories.*' => 'exists:categories,id',
        ]);

        $user = Auth::user();
        $user->categories()->sync($validated['categories']);

        return redirect()->route('home');
    }
}
