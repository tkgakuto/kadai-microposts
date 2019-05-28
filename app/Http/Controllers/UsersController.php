<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    { 
        $users = \App\User::orderBy('id','desc')->paginate(10);
        
        return view('users.index', [
            'users' => $users ,
            ]);
    }
    
    public function show($id)
    {
        $user = \App\User::find($id);
        $microposts =$user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        $data = [
            'user' => $user,
            'microposts' => $microposts,
            ];
            
            $data += $this->counts($user);
            
        return view('users.show',$data);
    }
    
    public function followings($id)
    {
        $user= \App\User::find($id);
        $followings =$user->followings()->paginate(10);
        
        $data= [
            'user'=> $user,
            'users' =>$followings,
            ];
            
        $data +=$this->counts($user);
        
        return view ('users.followings', $data);
    }
    
     public function followers($id)
    {
        $user = \App\User::find($id);
        $followers = $user->followers()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }
    
    //already favorite 
    public function favorites($id)
    {
        $user = \App\User::find($id);
        $favorites = $user->favorites()->paginate(10);
        
        $data = [
            'user'=> $user,
            'favorites'=>$favorites,
            ];
            
        $data += $this->counts($user);
        
        return view('users.favorites',$data);
        
    }
    
    
}


