<?php

namespace App\Http\Controllers;

use App\Models\Post; 

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
       $posts = Post::with(['categories'])->latest()->get();
       return view('home', compact('posts'));;
    }
}
