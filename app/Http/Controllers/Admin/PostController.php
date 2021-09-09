<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Storage;
class PostController extends Controller
{
    public function index(){
        $posts = Post::with('user')->paginate(25);
        return view('admin.posts.index', compact('posts'));
    }
    public function create(){
        return view('admin.posts.create');
    }
    public function edit(Post $post){
        return view('admin.posts.edit', compact('post'));
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'preview_text' => 'required',
            'detail_text' => 'required',
            'preview_picture' => 'image|max:4096',
            'detail_picture' => 'image|max:4096',
        ]);
        $data = $request->only([ 'title', 'preview_text', 'detail_text']);
        $data['user_id'] = auth()->id();
        if($request->has('preview_picture')){
            $data['preview_picture'] = $request->file('preview_picture')->store('posts');
        }
        if($request->has('detail_picture')){
            $data['detail_picture'] = $request->file('detail_picture')->store('posts');
        }
        Post::create($data);
        session()->flash('success', 'Запись успешно добавлена');
        return redirect()->route('admin.posts.index');
    }
    public function update(Request $request, Post $post){
        $request->validate([
            'title' => 'required',
            'preview_text' => 'required',
            'detail_text' => 'required',
            'preview_picture' => 'image|max:4096',
            'detail_picture' => 'image|max:4096',
        ]);
        $data = $request->only([ 'title', 'preview_text', 'detail_text']);
        if($request->has('preview_picture')){
            if($post->preview_picture) Storage::delete($post->preview_picture);
            $data['preview_picture'] = $request->file('preview_picture')->store('posts');
        }
        if($request->has('detail_picture')){
            if($post->detail_picture) Storage::delete($post->detail_picture);
            $data['detail_picture'] = $request->file('detail_picture')->store('posts');
        }
        $post->update($data);
        session()->flash('success', 'Запись успешно обновлена');
        return back();
    }
    public function removePreview(Post $post){
        Storage::delete($post->preview_picture);
        $post->preview_picture = null;
        $post->save();
        return back();
    }
    public function removeDetail(Post $post){
        Storage::delete($post->detail_picture);
        $post->detail_picture = null;
        $post->save();
        return back();
    }
}
