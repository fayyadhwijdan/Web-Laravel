<?php
namespace App\Http\Controllers\Api;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
//untuk delete gambar yg ada di folder storage
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Str;

class PostController extends Controller
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
        //$posts = Post::latest()->when(request()->q, function($posts) {
            //$posts = $posts->where('name', 'like', '%'. request()->q . '%');
        //})->paginate(10);
        $posts = Post::where('customer_id', auth()->guard('api')->user()->id)
        ->latest()
        //->with('approved') //ambil status approved
        ->paginate(10);
        //$posts = Post::latest()->paginate(10);

        //return response()->json([
            //'success' => true,
            //'message' => 'List Data Posts: '.auth()->guard('api')->user()->name,
            //'data'    => $posts  
        //], 200);
        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts' .auth()->guard('api')->user()->name, $posts);
		//return new PostResource(true, 'List Data Posts', $posts);
        //return view('admin.customer.index', compact('customers'));
    }
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
       //define validation rules
       $validator = Validator::make($request->all(), [
           'image'          => 'required|mimes:jpeg,jpg,png,mp4,y4m,mkv|max:67108864',
           'title'          => 'required',
           'template'       => 'required',
           'sender'         => 'required',

       ]); 

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

       //save to DB
       $post = Post::create([
           'customer_id'    => auth()->guard('api')->user()->id,
           'image'          => $image->hashName(),
           'title'          => $request->title,
           'template'       => $request->template,
           'sender'         => $request->sender,

       ]);

       //return response
       return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }
    
     /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $post = Post::findOrFail($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Post!', $post);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id) //request=data yg akan di update, id=id data yg akan di update
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'          => 'required',
            'template'       => 'required',
            'sender'         => 'required',

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = Post::find($id);

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.basename($post->image));

            //update post with new image
            $post->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'template'  => $request->template,
                'sender'    => $request->sender,
                
            ]);

        } else {

            //update post without image
            $post->update([
                'title'     => $request->title,
                'template'  => $request->template,
                'sender'    => $request->sender,
            ]);
        }

        //return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {

        //find post by ID
        $post = Post::find($id);

        //delete image
        Storage::delete('public/posts/'.basename($post->image));

        //delete post
        $post->delete();

        //return response
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
    }
    public function approve($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['approved' => true]);

        return new PostResource(true, 'Konten Berhasil di Approve!', $post);
    }
}
