<?php

namespace App\Http\Controllers\Admin;

use App\Models\Playlist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $playlists = Playlist::latest()->when(request()->q, function($playlists) {
            $playlists = $playlists->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.playlist.index', compact('playlists'));
    }
    
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $playlists = Playlist::latest()->get();
        return view('admin.playlist.create', compact('playlists'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
       $this->validate($request, [
           'image' => 'required|mimes:jpeg,jpg,png,mp4,y4m,mkv|max:67108864', 
           'name'  => 'required|unique:playlists',
           'linkcapcut' => 'required',
           'duration' => 'required|in:10detik,30detik',
           'linkcapcut' => 'required',
       ]); 

       //upload template
       $image = $request->file('image');
       $image->storeAs('public/playlists', $image->hashName());

       //save to DB
       $playlist = Playlist::create([
           'image'  => $image->hashName(),
           'name'   => $request->name,
           'slug'   => Str::slug($request->name, '-'),
           'linkcapcut' => $request->linkcapcut,
           'duration' => $request->input('duration')
       ]);

       if($playlist){
            //redirect dengan pesan sukses
            return redirect()->route('admin.playlist.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.playlist.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $playlist
     * @return void
     */
    public function edit(Playlist $playlist)
    {
        return view('admin.playlist.edit', compact('playlist'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $playlist
     * @return void
     */
    public function update(Request $request, Playlist $playlist)
    {
        $this->validate($request, [
            'name'  => 'required|unique:playlists,name,'.$playlist->id
        ]); 

        //check jika template kosong
        if($request->file('image') == '') {
            
            //update data tanpa template
            $playlist = Playlist::findOrFail($playlist->id);
            $playlist->update([
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-'),
                'linkcapcut' => $request->linkcapcut,
                'duration' => $request->input('duration')
            ]);

        } else {

            //hapus template lama
            Storage::disk('local')->delete('public/playlists/'.basename($playlist->image));

            //upload template baru
            $image = $request->file('image');
            $image->storeAs('public/playlists', $image->hashName());

            //update dengan template baru
            $playlist = Playlist::findOrFail($playlist->id);
            $playlist->update([
                'image'  => $image->hashName(),
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-'),
                'linkcapcut' => $request->linkcapcut,
                'duration' => $request->input('duration')
            ]);
        }

        if($playlist){
            //redirect dengan pesan sukses
            return redirect()->route('admin.playlist.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.playlist.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $playlist = Playlist::findOrFail($id);
        $image = Storage::disk('local')->delete('public/playlists/'.basename($playlist->image));
        $playlist->delete();

        if($playlist){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}