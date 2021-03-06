<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use Auth;

use Illuminate\Support\Facades\Validator;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class AuthController extends Controller
{
    public function register(Request $request, User $user){
        /*
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password'=> 'required|min:6'
        ]);
        //var_dump($validator);
        */
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password'=> 'required|min:6'
        ]); 
        
        $user = $user->create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=>bcrypt($request->password),
            'api_token'=>bcrypt($request->password)
        ]);
        $resource = ['data'=>
            [['name'=>$user['name'],'email'=>$user['email']]
            ]
        ];
        return response()->json($resource, 201);
    }

    public function login(Request $request, User $user){
        //$fractal = new Manager();
        
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json(['error'=>'your credential is error'], 401);
        }
        
        $user = $user->find(Auth::user()->id);
        $token = $user->createToken('authToken')->accessToken;

        $resource = ['data'=>
            [['name'=>$user['name'],'email'=>$user['email'],'token'=>$token]
            ]
        ];
        return response()->json($resource, 202);
    }
}
