<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;


class PostController extends Controller
{

    public function index()
    {

        $posts = Post::where('start_time', '<=', Carbon::now()->format('Y-m-d H:i:s'))
        ->where('end_time', '>=', Carbon::now()->format('Y-m-d H:i:s'))->get();

        return response($posts, 200);
     
    }


    public function store(Request $request)
    { 
      
        $path ;
        if ($request->hasfile('image')) {
            $image = $request->file('image');
       
    
            $name = $image->getClientOriginalName();
            
            $path = $image->storeAs('posts', $name, 'public');
          
       }
        $post = Post::create([
            'image' => $path,
            'title' => $request->title,
            'description' => $request->description,
            'start_time' =>  $request->start_time,
            'end_time' => $request->end_time,
            
        ]);
 
       
        return response($post, 201);
    }
}
