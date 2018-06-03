<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * summary
 */
class UserModel extends Model
{
	function scopeGetId($query, $username)
    {
        return DB::table('users')
        ->where('users.username', $username)
        ->value('id');
    }
    function scopeGetIdByToken($query, $api_token)
    {
        return DB::table('users')
        ->where('users.api_token', $api_token)
        ->value('id');
    }
	function scopeGetPass($query, $id)
    {
        return DB::table('users')
        ->where('users.id', $id)
        ->value('password');
    }
	function scopeUserDataByUsername($query, $username)
    {
    	return DB::table('users')
    	->select (
    		'users.id',
    		'users.name',
    		'users.email',
            'users.username',
    		'users.created_at',
    		'users.about',
    		'users.visitor',
    		'users.foto',
            'users.website',
            DB::raw('(select count(papers.idpapers) from papers where papers.id = users.id) as ttl_papers'),
            DB::raw('(select count(image.idimage) from image where image.id = users.id) as ttl_designs'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.id = users.id) as ttl_saved')
    	)
    	->where('users.username', $username)
    	->get();
    }
    function scopeSearchUsers($query, $ctr, $limit)
    {
        $searchValues = preg_split('/\s+/', $ctr, -1, PREG_SPLIT_NO_EMPTY);
        return DB::table('users')
        ->select (
            'users.id',
            'users.name',
            'users.email',
            'users.username',
            'users.created_at',
            'users.about',
            'users.visitor',
            'users.foto',
            'users.website',
            DB::raw('(select count(papers.idpapers) from papers where papers.id = users.id) as ttl_papers'),
            DB::raw('(select count(image.idimage) from image where image.id = users.id) as ttl_designs'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.id = users.id) as ttl_saved')
        )
        ->where('users.name','like',"%$ctr%")
        ->orWhere('users.username','like',"%$ctr%")
        ->orWhere('users.about','like',"%$ctr%")
        ->orWhere(function ($q) use ($searchValues)
        {
            foreach ($searchValues as $value) {
                $q->orWhere('users.name','like',"%$value%");
                $q->orWhere('users.username','like',"%$value%");
                $q->orWhere('users.about','like',"%$value%");
            }
        })
        ->limit($limit)
        ->get();
    }
}