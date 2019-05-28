<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    
    public function followings()
    {
        //user_idがfollow_idをフォローしている
     return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
     
    }
    
    public function followers()
    {
        //follow_idはuser_idをフォローする。フォローワーを呼ぶ
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id','user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        //すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        //相手が自分ではないかの確認
        $its_me = $this->id == $userId;
        
        if ($exist || $its_me) {
            //すでにフォローしていたら何もしない
            return false;
        } else {
            //見フォローであればする
            $this->followings()->attach($userId);
            return true;
        }
        
     }
     
    public function unfollow($userId)
    {
        $exist= $this->is_following($userId);
        
        $its_me= $this->id == $userId;
        
        if ($exist && !$its_me) {
            //すでにフォローしていれば外す
            $this->followings()->detach($userId);
            return true;
        } else {
            
            return false;
        }
    }
    
    public function is_following ($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    public function feed_microposts()
    {
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
    public function favorites(){
        //お気に入りしている
        return $this->belongsToMany(Micropost::class, 'user_favorite', 'user_id','micropost_id')->withTimestamps();
    }
    
    public function favorite($micropostId){
        $exist = $this->is_favorites($micropostId);
        if($exist) {
            return false;
        }
        else {
            $this->favorites()->attach($micropostId);
            return true;
        }
        
    }
    
    public function unfavorite($micropostId){
        $exist = $this->is_favorites($micropostId);
        if($exist) {
            $this->favorites()->detach($micropostId);
            return true;
        }
        else {
            return false;
        }
    }
    
    public function is_favorites($micropostId){
        return $this->favorites()->where('micropost_id',$micropostId)->exists();
    }
}

