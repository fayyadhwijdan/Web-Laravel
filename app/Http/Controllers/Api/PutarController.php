<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Putar;

class PutarController extends Controller

{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $putars = Putar::latest()->get();
        return response()->json([
            'success'       => true,
            'message'       => 'List Data Putar',
            'putars'        => $putars
        ]);
    }
    //public function index()
    //{
        //$posts = Post::latest()->with('approved')->get();
            //return response()->json([
            //'success'       => true,
            //'message'       => 'List Data Putar',
            //'posts'         => $posts
        //]);
    //}
    /**
     * show
     *
     * @param  mixed $slug
     * @return void
     */
    //public function show($slug)
    //{
        //$putar = Putar::where('slug', $slug)->first();

        //if($putar) {

            //return response()->json([
                //'success' => true,
                //'message' => 'List Product By Putar: '. $putar->sender,
                //"putar" => $putar->putars()->latest()->get()
            //], 200);

        //} else {

            //return response()->json([
                //'success' => false,
                //'message' => 'Data Putar Tidak Ditemukan',
            //], 404);

        //}
    //}

    /**
     * putarHeader
     *
     * @return void
     */
    //public function putarHeader()
    //{
        //$putars = Putar::latest()->take(5)->get();
        //return response()->json([
            //'success'       => true,
            //'message'       => 'List Data Putar Header',
            //'putars'        => $putars
        //]);
    //}

}
