<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Comment;
use Auth;

class CommentController extends Controller
{
	const COMMENTS_PAGE_NUM = 5;

	public function __construct()
	{
		$this->middleware('auth', ['except' => 'getAll']);
	}

    public function add(Request $request, User $userModel)
    {
    	$this->validate($request, [
    		'comment' => 'required|max:1000',
    		'userId' => 'bail|required|integer'
    	]);

    	$comment = $request->input('comment');
    	$userProfileId = $request->input('userId');
    	$userAuthId = Auth::user()->id;
    	Comment::create([
    		'id_who' => $userAuthId,
    		'id_target' => $userProfileId,
    		'comment' => $comment
    	]);

    	$userProfile = $userModel->getUserProfile($userProfileId, $userAuthId);
    	return view('user.comments', ['whoComment' => $userProfile->whoComment,
    		'userProfile' => $userProfile, 'authId' => Auth::user()->id]);
    }

    public function delete($commentId, Request $request, User $userModel)
    {
    	$comment = Comment::find($commentId);
        if (!$comment) {
            abort(422);
        }
    	if ($comment->id_who != Auth::user()->id) {
    		abort(403);
    	}
    	$comment->delete();

        return response()->json(['deleted' => 'true']);
    }

    public function recover($commentId, Request $request)
    {
        $comment = Comment::onlyTrashed()->find($commentId);
        if (!$comment) {
            abort(422);
        }
        if ($comment->id_who != Auth::user()->id) {
            abort(403);
        }
        $comment->restore();

        return response()->json(['recovered' => 'true']);
    }

    public function getAll($userId)
    {
    	$user = User::findOrFail($userId);
    	$whoComment = $user->whoComment()->paginate(self::COMMENTS_PAGE_NUM);
    	return view('user.allComments', ['user' => $user, 'whoComment' => $whoComment,
    		'authId' => Auth::check() ? Auth::user()->id : null]);
    }
}
