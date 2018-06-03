<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * summary
 */
class TagModel extends Model
{
    function scopeGetTagById($scope, $idtags)
    {
        return DB::table('tags')
        ->where('idtags', $idtags)
        ->value('tag');
    }
    function scopeGetTag($scope, $idtarget, $type)
    {
    	return DB::table('tags')
    	->select(
    		'idtags',
    		'tag'
    	)
    	->where('idtarget', $idtarget)
    	->where('type', $type)
        ->orderBy('idtags', 'asc')
    	->get();
    }
    function scopeSearchTags($query, $ctr, $limit)
    {
        $searchValues = preg_split('/\s+/', $ctr, -1, PREG_SPLIT_NO_EMPTY);
        return DB::table('tags')
        ->select(
            'idtags',
            'tag',
            DB::raw('count(idtags) as ttl_tag')
        )
        ->where(function ($q) use ($searchValues)
        {
            foreach ($searchValues as $value) {
                $q->orWhere('tags.tag','like',"%$value%");
            }
        })
        ->groupBy('tag')
        ->orderBy('ttl_tag', 'desc')
        ->limit($limit)
        ->get();
    }
    function scopePopularTag($query, $limit)
    {
        return DB::table('tags')
        ->select(
            'idtags',
            'tag',
            DB::raw('count(idtags) as ttl_tag')
        )
        ->groupBy('tag')
        ->orderBy('ttl_tag', 'desc')
        ->limit($limit)
        ->get();
    }
}
