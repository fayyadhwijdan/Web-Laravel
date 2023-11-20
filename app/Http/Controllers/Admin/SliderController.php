<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $sliders = Slider::latest()->when(request()->q, function($sliders) {
            $sliders = $sliders->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('admin.slider.create');
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
            'image' => 'required|mimes:jpeg,jpg,png,mp4,mkv|max:67108864',
            'link'  => 'required' 
        ]); 
 
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());
 
        //save to DB
        $slider = Slider::create([
            'image'  => $image->hashName(),
            'link'   => $request->link
        ]);
 
        if($slider){
             //redirect dengan pesan sukses
             return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Disimpan!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $slider = Slider::findOrFail($id);
        $image = Storage::disk('local')->delete('public/sliders/'.basename($slider->image));
        $slider->delete();

        if($slider){
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