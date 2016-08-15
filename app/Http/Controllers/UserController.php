<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\User;

class UserController extends Controller
{
    const HISTORY_PAGE_NUM = 15;

	public function __construct()
	{
		$this->middleware('auth', ['except' => ['profile', 'history']]);
	}

    public function editUserData()
    {
    	return view('user.editProfile', ['user' => Auth::user()]);
    }

    public function updateUserData(Request $request, User $userModel)
    {
    	$this->validate($request, [
            'avatar' => 'mimes:jpeg,jpg,gif,png|max:5000',
            'sex' => 'required|in:male,female',
        ]);

        if ($request->hasFile('avatar')) {
            $userModel->setUserAvatar($request->file('avatar'), Auth::user()->id);
        }

        $user = User::findOrFail(Auth::user()->id);
        $user->sex = $request->input('sex');
        $user->save();
    	return redirect()->route('editProfile');
    }

    public function profile($userProfileId, User $userModel)
    {
        // echo strftime('%A') . '<br>';
        // echo setlocale(LC_TIME, config('app.locale')) . '<br>';
        // echo strftime('%A');
        // exit;
        // echo \Jenssegers\Date\Date::now()->format('l j F Y H:i:s');
        // exit;
        $userProfile = $userModel->getUserProfile($userProfileId, Auth::check() ? Auth::user()->id : null);
        return view('user.profile', [
            'userProfile' => $userProfile, 'authId' => Auth::check() ? Auth::user()->id : null
        ]);
    }

    public function history($userId, User $userModel)
    {
        $user = User::findOrFail($userId);
        $whoVote = $user->whoVote()->paginate(self::HISTORY_PAGE_NUM);
        return view('user.history', ['user' => $user, 'whoVote' => $whoVote]);
    }
}
