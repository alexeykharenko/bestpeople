<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;
use Image;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'password', 'avatar', 'sex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const AVATARS_FOLDER = 'uploads/avatars/';

    public function setUserAvatar($avatar, $userId)
    {
        $user = User::findOrFail($userId);
        $disk = Storage::disk('public');
        if ($user->avatar != 'default.png') {
            $disk->delete(self::AVATARS_FOLDER . $user->avatar);
        }
        $filename = $user->id . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->resize(50, 50)->save(public_path(self::AVATARS_FOLDER) . $filename);
        //$avatar->move(public_path(self::AVATARS_FOLDER), $filename);
        //$disk->put(self::AVATARS_FOLDER . $filename, $avatar);
        $user->avatar = $filename;
        return $user->save();
    }

    public function getBestPeople($userAuthId, $userByPage)
    {
        $bestPeople = User::orderBy('karma', 'desc')->with(
            ['getVotes' => function ($query) use ($userAuthId) {
                $query->where('id_who', $userAuthId);
            }]
        )->paginate($userByPage);
        return $bestPeople;
    }

    public function getUserProfile($userProfileId, $userAuthId)
    {
        $profile = User::with(['getVotes' => function ($query) use ($userAuthId) {
            $query->where('id_who', $userAuthId);
        }])->findOrFail($userProfileId);
        return $profile;
    }

    public function plusKarma($userId)
    {
        $user = User::findOrFail($userId);
        $user->karma++;
        return $user->save();
    }

    public function minusKarma($userId)
    {
        $user = User::findOrFail($userId);
        $user->karma--;
        return $user->save();
    }

    public function getVotes()
    {
        return $this->hasMany('App\Vote', 'id_target');
    }

    public function whoVote()
    {
        return $this->belongsToMany('App\User', 'votes', 'id_target', 'id_who')->withPivot('vote')
            ->withTimestamps()->orderBy('pivot_updated_at', 'desc');
    }

    public function whoComment()
    {
        return $this->belongsToMany('App\User', 'comments', 'id_target', 'id_who')
            ->withPivot('comment', 'id', 'deleted_at')->withTimestamps()->whereNull('comments.deleted_at')
            ->orderBy('pivot_updated_at', 'desc');
    }

    // public function getUpdatedAtAttribute($date)
    // {
    //     dd('pivot');
    //     $DATE = new \Jenssegers\Date\Date($date);
    //     return $DATE->format('l j F Y H:i:s');
    // }

    // public function getCreatedAtAttribute($date)
    // {
    //     $DATE = new \Jenssegers\Date\Date($date);
    //     return $DATE->format('l j F Y H:i:s');
    // }
}
