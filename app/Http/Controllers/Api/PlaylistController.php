<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $playlists = Playlist::latest()->get();
        return response()->json([
            'success'       => true,
            'message'       => 'List Data Playlist',
            'playlists'    => $playlists
        ]);
    }
    
    /**
     * show
     *
     * @param  mixed $slug
     * @return void
     */
    public function show($slug)
    {
        $playlist = Playlist::where('slug', $slug)->first();

        if($playlist) {

            return response()->json([
                'success' => true,
                'message' => 'List Content By Playlist',
                'playlist' => $playlist
            ], 200);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Data Content By Playlist Tidak Ditemukan',
            ], 404);

        }
    }
    
    /**
     * playlistHeader
     *
     * @return void
     */
    public function playlistHeader()
    {
        $playlists = Playlist::latest()->take(5)->get();
        return response()->json([
            'success'       => true,
            'message'       => 'List Data Playlist Header',
            'playlists'    => $playlists
        ]);
    }

}