<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * summary
 */
class CommentModel extends Model
{
    /**
     * summary
     */
    function scopeGetComment($scope, $iddesign, $offset, $limit)
    {
    	return DB::table('comment')
    	->select(
    		'comment.idcomment',
    		'comment.description',
    		'comment.created',
    		'comment.id',
    		'users.name',
    		'users.username',
    		'users.foto'
    	)
    	->where('comment.idimage',$iddesign)
    	->join('users','users.id','=','comment.id')
    	->orderBy('comment.idcomment','desc')
    	->offset($offset)
    	->limit($limit)
    	->get();
    }
}
