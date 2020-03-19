<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Post;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class UserController extends Controller
{
    public function users(User $user){
        $fractal = new Manager();
        
        $users = $user->all();
        $resource = new Collection($users, function($user) {
            return [
              'name'=>$user->name,
              'email'=>$user->email
            ];
        });
        return $fractal->createData($resource)->toJson();
        
    }

    public function userbyId(User $user,$id){
        $user = $user::find($id);
       
        //karena response cuma 1 tidak bisa pakai fractal
        $resource = ['data'=>
            [['name'=>$user['name'],'email'=>$user['email']]
            ]
        ];
        return response()->json($resource);       
    }

    public function profile(User $user,$id){
        //$user = $user->find(Auth::user()->id);//ini jika tanpa $id otomatis di ambil dari auth
        $user = $user->find($id);
        $post = $user->post()->get();
        $resource = ['data'=>
            [['name'=>$user['name'],'email'=>$user['email'],'register'=>$user['created_at']
            ,'post'=>$post]
            ]
        ];
        return response()->json($resource);
    }

    
}
