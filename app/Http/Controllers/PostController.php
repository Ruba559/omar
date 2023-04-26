<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;


class PostController extends Controller
{

    public function index()
    {

        $posts = Post::where('startAt', '<=', Carbon::now()->format('Y-m-d H:i:s'))
        ->where('endAt', '>=', Carbon::now()->format('Y-m-d H:i:s'))->get();

        return response($posts, 200);
     
    }


    public function postById($id)
    {

        $post = Post::where('id' , $id)->first();

        return response($post, 200);
     
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
            'price' => $request->price,
            'startAt' => $request->startAt,
            'endAt' =>  $request->endAt,
            'commission' => $request->commission,
            
        ]);
 
       
        return response($post, 201);
    }
}
