<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void

    public function __construct()
    {
        $this->middleware('auth');
    }
*/
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       // dd(\Auth::check()); proverka usera na login
        $posts = Post::paginate(2);
        return view('pages.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
      //  dd($post->comments);
        return view('pages.show', compact('post'));
    }


    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->simplePaginate(2);
        //$posts = Post::paginate(2);
        return view('pages.list', compact('posts'));
    }


    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        //dd($tag);
        $posts = $tag->posts()->paginate(2);
        //dd($posts);
        return view('pages.list', compact('posts'));
    }
}
