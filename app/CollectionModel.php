<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * summary
 */
class collectionModel extends Model
{
    /**
     * summary
     */
    function scopeGetAll($scope)
    {
    	return DB::table('tags')
        ->select(
            'idtags',
            'tag',
            DB::raw('count(idtags) as ttl_tag')
        )
        ->groupBy('tag')
        ->having('ttl_tag','>=','2')
        ->orderBy('tag', 'asc')
        ->limit(35)
        ->get();
    }
}
