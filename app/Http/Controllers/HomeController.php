<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
class HomeController extends Controller
{
    public function faq(){
        return view('site.faq');
    }
    public function about(){
        return view('site.about');
    }
    public function posts(){
        $posts = Post::with('user')->paginate(8);
        return view('site.posts.index', compact('posts'));
    }
    public function post(Post $post){
        $post->load('user');
        return view('site.posts.show', compact('post'));
    }
}
