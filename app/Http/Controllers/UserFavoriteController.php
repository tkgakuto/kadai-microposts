<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function store(Request $request,$micropost){
        \Auth::user()->favorite($micropost);
        return back();
    }
    
    public function destroy($micropost){
        \Auth::user()->unfavorite($micropost);
        return back();
    }
}
