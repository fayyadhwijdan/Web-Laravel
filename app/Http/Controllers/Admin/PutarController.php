<?php

namespace App\Http\Controllers\Admin;

use App\Models\Putar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PutarController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $putars = Putar::latest()->when(request()->q, function($putars) {
            $putars = $putars->where('duration', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.putar.index', compact('putars'));
    }
    
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('admin.putar.create');
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
           'image'          => 'required|mimes:jpeg,jpg,png,heif,heic,mp4,y4m,mkv,mov,raw,arw|max:67108864',
           'duration'         => 'required|in:10detik,30detik'

       ]); 

       //upload image
       $image = $request->file('image');
       $image->storeAs('public/putars', $image->hashName());

       //save to DB
       $putar = Putar::create([
           'image'          => $image->hashName(),
           'duration'       => $request->input('duration')

       ]);

       if($putar){
            //redirect dengan pesan sukses
            return redirect()->route('admin.putar.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.putar.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * edit
     *
     * @param  mixed $putar
     * @return void
     */
    public function edit(Putar $putar)
    {
        return view('admin.putar.edit', compact('putar'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $putar
     * @return void
     */
    public function update(Request $request, Putar $putar)
    {
       $this->validate($request, [
           'duration' => $request->input('duration')
       ]); 

       //cek jika image kosong
       if($request->file('image') == '') {

            //update tanpa image
            $putar = Putar::findOrFail($putar->id);
            $putar->update([
                'duration' => $request->input('duration')
            ]);

       } else {

            //hapus image lama
            Storage::disk('local')->delete('public/putars/'.basename($putar->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/putars', $image->hashName());

            //update dengan image
            $putar = Putar::findOrFail($putar->id);
            $putar->update([
                'image'          => $image->hashName(),
                'duration' => $request->input('duration')
            ]);
       }

       if($putar){
            //redirect dengan pesan sukses
            return redirect()->route('admin.putar.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.putar.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $putar = Putar::findOrFail($id);
        $image = Storage::disk('local')->delete('public/putars/'.basename($putar->image));
        $putar->delete();

        if($putar){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
};