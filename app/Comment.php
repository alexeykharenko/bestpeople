<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use SoftDeletes;

    protected $fillable = ['id_who', 'id_target', 'comment'];
    protected $dates = ['deleted_at'];
}
