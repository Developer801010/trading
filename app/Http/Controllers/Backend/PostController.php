<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Post::orderBy('created_at', 'desc')->get();
        
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{

            $title = $request->title;
            $content = $request->quill_html;

            $postObj = new Post();
            
            // Extract base64 encoded image data from Quill content
            $pattern = '/data:image\/(.*?);base64,([^\'"]*)/';

            $content = preg_replace_callback($pattern, function ($match) {
                $extension = $match[1]; // Get image extension
                $base64Image = $match[2]; // Get base64 image data
                $imageData = base64_decode($base64Image); // Decode base64 data

                // Generate a unique identifier for the image name
                $uniqueIdentifier = uniqid();

                // Combine unique identifier and current timestamp for the image name
                $imageName = 'image_' . $uniqueIdentifier.'_'. time() . '.' . $extension;
                $imagePath = public_path('uploads/article/' . $imageName);
                file_put_contents($imagePath, $imageData);

                // Replace base64 encoded image with URL
                $imageUrl = asset('uploads/article/' . $imageName);

                return $imageUrl;
            }, $content);

            $postObj->title = $title;
            $postObj->content = $content;

            if($request->hasFile('image')){
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
        
                $imageName = time().'.'.$request->image->extension();    
                $request->image->move(public_path('uploads/article'), $imageName);

                $postObj->post_image = 'uploads/article/' . $imageName;
            }

            $postObj->save();
            DB::commit();

            return redirect()->route('articles.index')->with('flash_success', 'Article was created successfully!')->withInput();

        }catch(Exception $ex){
            DB::rollBack();
            return back()->withErrors($ex->getMessage())->withInput();
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
