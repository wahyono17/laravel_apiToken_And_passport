<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Auth;

class PostController extends Controller
{
    public function add(Request $request, Post $post){
        $request->validate([
            'content'=>'required|min:8'
        ]);

        $post = $post->create([
            'user_id'=>Auth::user()->id,
            'content'=>$request->content
        ]);
        $resource = ['data'=>
            [['id'=>$post['id'],'user_id'=>$post['user_id'],'content'=>$post['content']]
            ]
        ];
        return response()->json($resource, 201);
    }

    public function update(Request $request, Post $post){
        $this->authorize('update',$post);

        $request->validate(['content'=>'required']);
        //$post = $post->find($id);
        $post->content = $request->content;
        $post->save();

        return response()->json($post, 200);
    }

    public function delete(Post $post){
        $this->authorize('delete',$post);

        $post->delete();
        return response()->json(['messages'=>'Post Deleted'], 200);
    }
}
