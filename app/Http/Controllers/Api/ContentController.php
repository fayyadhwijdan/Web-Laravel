<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $posts = Post::where('customer_id', auth()->guard('api')->user()->id)->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Posts: '.auth()->guard('api')->user()->name,
            'data'    => $posts  
        ], 200);

    }
    
    /**
     * show
     *
     * @param  mixed $snap_token
     * @return void
     */
    public function show($snap_token)
    {
        $post = Post::where('customer_id', auth()->guard('api')->user()->id)->where('snap_token', $snap_token)->latest()->first();

        return response()->json([
            'success' => true,
            'message' => 'Detail Posts: '.auth()->guard('api')->user()->name,
            'data'    => $post, 
            'product' => $post->contents 
        ], 200);

    }
}