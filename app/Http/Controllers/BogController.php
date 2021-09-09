<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
class BogController extends Controller
{
    public function index(){
        $posts = POst::paginate(8);
        return view('site.blog.index', compact('posts'));
    }
}
