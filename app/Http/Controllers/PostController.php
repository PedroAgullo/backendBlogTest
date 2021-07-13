<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Esta función te trae todos los posts

    public function index()
    {
        $posts = auth()->user()->posts;

        return response() ->json([
            'success' => true,
            'data' => $posts,
        ]);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $this->validate( $request , [
            'title' => 'required',
        ]);

        $post = new Post () ;

        $post -> title = $request -> title;

        if(auth()->user()->posts()->save($post)){

            return response() ->json([
                'success' => true,
                'data' => $post->toArray()
            ], 200);

        }

        return response() ->json([
            'success' => false,
            'message' => 'Post not added',
        ], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */


    // Esta función te muestra un post segun su id

    public function show($id)
    {
        $post = auth()->user()->posts()->find($id);

        if(!$post){

            return response() ->json([
                'success' => false,
                'message' => 'Post not found',
            ], 400);

        }

        return response() ->json([
            'success' => true,
            'data' => $post,
        ], 200);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = auth()->user()->posts()->find($id);

        if(!$post){

            return response() ->json([
                'success' => false,
                'message' => 'Post not found',
            ], 400);

        }

        // $updated = $post->fill($request->all())->save();

        $updated = $post->update([
            'title' => $request->input('title'),
        ]);

        if($updated){
            return response() ->json([
                'success' => true,
            ]);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'Post can not be updated',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);

        if(!$post){

            return response() ->json([
                'success' => false,
                'message' => 'Post not found',
            ], 400);

        }

        if($post -> delete()){
            return response() ->json([
                'success' => true,
            ], 200);
            
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'Post can not be deleted',
            ], 500);
        }
    }
}
