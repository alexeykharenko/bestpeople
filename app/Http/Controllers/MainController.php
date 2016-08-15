<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Vote;
use Auth;
use Validator;

class MainController extends Controller
{
    const TOP_PAGE_NUM = 15;

    public function index(User $userModel)
    {
    	$bestPeople = $userModel->getBestPeople(Auth::check() ? Auth::user()->id : null,
    		self::TOP_PAGE_NUM);
    	return view('main.mainPage', [
    		'bestPeople' => $bestPeople, 'authId' => Auth::check() ? Auth::user()->id : null
    	]);
    }
}
