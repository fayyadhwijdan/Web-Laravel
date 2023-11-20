<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
//use App\Models\Playlist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $posts = Post::latest()->when(request()->q, function($posts) {
            $posts = $posts->where('sender', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.content.index', compact('posts'));
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.content.show', compact('post'));
    }
    
    public function approve($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['approved' => true]);

        return redirect()->back()->with('success', 'Konten berhasil diapprove!');
    }

}
