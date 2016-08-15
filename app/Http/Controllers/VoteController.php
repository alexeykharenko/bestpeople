<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\User;
use App\Vote;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function vote(Request $request, Vote $voteModel, User $userModel)
    {
    	$this->validate($request, [
    		'userId' => 'bail|required|integer',
    		'karma' => 'required|in:plus,minus',
    	]);

    	$userWhoId = Auth::user()->id;
    	$userTargetId = $request->input('userId');
    	$karma = $request->input('karma');
    	if ($userWhoId == $userTargetId || !$voteModel->vote($userWhoId, $userTargetId, $karma)) {
    		abort(500, 'Database error');
    	}

        $from = $request->input('from');
        if ($from == 'topList') {
        	$bestPeople = $userModel->getBestPeople($userWhoId, 15);
            return view('main.topList', [
                'bestPeople' => $bestPeople, 'authId' => Auth::user()->id
            ]);
        }
        if ($from == 'profile') {
            $profile = $userModel->getUserProfile($userTargetId, $userWhoId);
            return view('user.userInfo', [
                'userProfile' => $profile, 'authId' => Auth::user()->id
            ]);
        }
    }
}
