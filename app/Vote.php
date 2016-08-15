<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
	protected $fillable = ['id_who', 'id_target', 'vote'];

    public function vote($userWhoId, $userTargetId, $karma)
    {
    	$vote = Vote::voted($userWhoId, $userTargetId)->first();
    	if (isset($vote) && $vote->vote == $karma) {
    		return false;
    	}

    	$userModel = new User;
    	if ($karma == 'plus') {
    		$userModel->plusKarma($userTargetId);
    	} else if ($karma == 'minus') {
    		$userModel->minusKarma($userTargetId);
    	} else {
            return false;
        }

    	if (isset($vote)) {
    		return Vote::voted($userWhoId, $userTargetId)->delete();
    	}
    	return Vote::create([
    		'id_who' => $userWhoId,
    		'id_target' => $userTargetId,
    		'vote' => $karma
    	]);
    }

    public function scopeVoted($query, $userWhoId, $userTargetId)
    {
    	return $query->where('id_who', $userWhoId)->where('id_target', $userTargetId);
    }
}
