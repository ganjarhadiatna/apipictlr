<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * summary
 */
class PaperModel extends Model
{
    /**
     * summary
     */
    function scopeDetailPaper($query, $idpapers)
    {
    	return DB::table('papers')
        ->select(
            'papers.idpapers',
            'papers.title',
            'papers.description',
            'papers.created',
            'papers.id',
            'papers.views',
            'users.username',
            'users.foto',
            DB::raw('(select count(image.idimage) from image where image.idpapers = papers.idpapers) as ttl_design'),
            DB::raw('(select count(watchs.idwatchs) from watchs where watchs.idpapers = papers.idpapers) as ttl_watch')
        )
        ->join('users','users.id', '=', 'papers.id')
        ->where('papers.idpapers', $idpapers)
        ->get();
    }
    function scopeUserPaper($query, $limit, $id)
    {
        return DB::table('papers')
        ->select(
            'papers.idpapers',
            'papers.title',
            'papers.description',
            'papers.created',
            'papers.id',
            'papers.views',
            'users.username',
            'users.foto',
            DB::raw('(select image.image from image where image.idpapers = papers.idpapers limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idpapers = papers.idpapers limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idpapers = papers.idpapers limit 1 offset 2) as cover3'),
            DB::raw('(select count(image.idimage) from image where image.idpapers = papers.idpapers) as ttl_design'),
            DB::raw('(select count(watchs.idwatchs) from watchs where watchs.idpapers = papers.idpapers) as ttl_watch')
        )
        ->join('users','users.id', '=', 'papers.id')
        ->where('papers.id', $id)
        ->orderBy('papers.title','asc')
        ->limit($limit)
        ->get();
    }
    function scopeSearchPaper($query, $ctr, $limit)
    {
        $searchValues = preg_split('/\s+/', $ctr, -1, PREG_SPLIT_NO_EMPTY);
        return DB::table('papers')
        ->select(
            'papers.idpapers',
            'papers.title',
            'papers.description',
            'papers.created',
            'papers.id',
            'papers.views',
            'users.username',
            'users.foto',
            DB::raw('(select image.image from image where image.idpapers = papers.idpapers limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idpapers = papers.idpapers limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idpapers = papers.idpapers limit 1 offset 2) as cover3'),
            DB::raw('(select count(image.idimage) from image where image.idpapers = papers.idpapers) as ttl_design'),
            DB::raw('(select count(watchs.idwatchs) from watchs where watchs.idpapers = papers.idpapers) as ttl_watch')
        )
        ->join('users','users.id', '=', 'papers.id')
        ->where('papers.title','like',"%$ctr%")
        ->orWhere('papers.description','like',"%$ctr%")
        ->orWhere(function ($q) use ($searchValues)
        {
            foreach ($searchValues as $value) {
                $q->orWhere('papers.title','like',"%$value%");
                $q->orWhere('papers.description','like',"%$value%");
            }
        })
        ->orderBy('papers.idpapers','desc')
        ->limit($limit)
        ->get();
    }
}