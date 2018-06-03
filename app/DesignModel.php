<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class DesignModel extends Model
{
    function scopeImageDesign($scope, $iddesign)
    {
        return DB::table('image')
        ->where('idimage', $iddesign)
        ->value('image');
    }
    function scopeDetailDesign($query, $iddesign)
    {
        return DB::table('image')
        ->select(
            'image.image',
            'image.description',
            'image.views',
            'image.created',
            'image.width',
            'image.height',
            'users.id',
            'users.foto',
            'users.username',
            'papers.idpapers',
            'papers.title'
        )
        ->join('users','users.id','=','image.id')
        ->join('papers','papers.idpapers','=','image.idpapers')
        ->where('idimage', $iddesign)
        ->get();
    }
    function scopeOtherDesign($query, $idpapers, $limit = 8)
    {
        return DB::table('image')
        ->select(
            'image.idimage',
            'image.image',
            'image.description',
            'image.views'
        )
        ->where('idpapers', $idpapers)
        ->orderBy('image.idimage', 'desc')
        ->limit($limit)
        ->get();
    }
    function scopeTagDesign($query, $ctr, $limit)
    {
        $id = 0;
        $searchValues = preg_split('/\s+/', $ctr, -1, PREG_SPLIT_NO_EMPTY);
        return DB::table('image')
        ->select(
            'image.idimage',
            'image.image as cover',
            'image.description',
            'image.width',
            'image.height',
            'papers.idpapers',
            'papers.created',
            'papers.title',
            'papers.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idimage = image.idimage) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idimage = image.idimage and bookmark.id = '.$id.' limit 1) as is_save')
        )
        ->join('papers','papers.idpapers', '=', 'image.idpapers')
        ->join('users','users.id', '=', 'image.id')
        ->leftJoin('tags','tags.idtarget', '=', 'image.idimage')
        ->where('tags.tag', 'like', '%'.$ctr.'%')
        ->orWhere('papers.title','like',"%$ctr%")
        ->orWhere('papers.description','like',"%$ctr%")
        ->orWhere('image.description','like',"%$ctr%")
        ->orWhere('users.name','like',"%$ctr%")
        ->orWhere(function ($q) use ($searchValues)
        {
            foreach ($searchValues as $value) {
                $q->orWhere('image.description','like',"%$value%");
                $q->orWhere('papers.title','like',"%$value%");
                $q->orWhere('papers.description','like',"%$value%");
            }
        })
        ->orderBy('image.idimage', 'desc')
        ->groupBy('image.idimage')
        ->limit($limit)
        ->get();
    }
    function scopeTimelinesDesign($query, $limit, $paper, $id)
    {
        return DB::table('image')
        ->select(
            'image.idimage',
            'image.image as cover',
            'image.description',
            'image.width',
            'image.height',
            'papers.idpapers',
            'papers.created',
            'papers.title',
            'papers.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idimage = image.idimage) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idimage = image.idimage and bookmark.id = '.$id.' limit 1) as is_save')
        )
        ->join('papers','papers.idpapers', '=', 'image.idpapers')
        ->join('users','users.id', '=', 'image.id')
        ->where('papers.id', $id)
        ->orWhere(function ($q) use ($paper)
        {
            foreach ($paper as $value) {
                $q->orWhere('papers.idpapers', $value->idpapers);
            }
        })
        ->orderBy('image.idimage', 'desc')
        ->limit($limit)
        ->get();
    }
	function scopeFreshDesign($query, $limit)
    {
        $id = 0;
        return DB::table('image')
        ->select(
            'image.idimage',
            'image.image as cover',
            'image.description',
            'image.width',
            'image.height',
            'image.views',
            'papers.idpapers',
            'papers.created',
            'papers.title',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idimage = image.idimage) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idimage = image.idimage and bookmark.id = '.$id.' limit 1) as is_save')
        )
        ->join('papers','papers.idpapers', '=', 'image.idpapers')
        ->join('users','users.id', '=', 'image.id')
        ->orderBy('image.idimage', 'desc')
        ->limit($limit)
        ->get();
    }
    function scopePopularDesign($query, $limit)
    {
        $id = 0;
        return DB::table('image')
        ->select(
            'image.idimage',
            'image.image as cover',
            'image.description',
            'image.width',
            'image.height',
            'image.views',
            'papers.idpapers',
            'papers.created',
            'papers.title',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idimage = image.idimage) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idimage = image.idimage and bookmark.id = '.$id.' limit 1) as is_save')
        )
        ->join('papers','papers.idpapers', '=', 'image.idpapers')
        ->join('users','users.id', '=', 'image.id')
        ->orderBy('image.views', 'asc')
        ->limit($limit)
        ->get();
    }

    //trending harus dirubah kembali
    function scopeTrendingDesign($query, $limit)
    {
        $id = 0;
        return DB::table('image')
        ->select(
            'image.idimage',
            'image.image as cover',
            'image.description',
            'image.width',
            'image.height',
            'image.views',
            'papers.idpapers',
            'papers.created',
            'papers.title',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idimage = image.idimage) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idimage = image.idimage and bookmark.id = '.$id.' limit 1) as is_save')
        )
        ->join('papers','papers.idpapers', '=', 'image.idpapers')
        ->join('users','users.id', '=', 'image.id')
        ->orderBy('image.views', 'desc')
        ->limit($limit)
        ->get();
    }
    function scopePaperDesign($query, $idpapers, $limit)
    {
        $id = 0;
        return DB::table('image')
        ->select(
            'image.idimage',
            'image.image as cover',
            'image.description',
            'image.width',
            'image.height',
            'image.views',
            'papers.idpapers',
            'papers.created',
            'papers.title',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idimage = image.idimage) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idimage = image.idimage and bookmark.id = '.$id.' limit 1) as is_save')
        )
        ->join('papers','papers.idpapers', '=', 'image.idpapers')
        ->join('users','users.id', '=', 'image.id')
        ->where('image.idpapers', $idpapers)
        ->orderBy('image.idimage', 'desc')
        ->limit($limit)
        ->get();
    }
    function scopeUserDesign($query, $id, $limit)
    {
        return DB::table('image')
        ->select(
            'image.idimage',
            'image.image as cover',
            'image.description',
            'image.width',
            'image.height',
            'image.views',
            'papers.idpapers',
            'papers.created',
            'papers.title',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idimage = image.idimage) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idimage = image.idimage and bookmark.id = '.$id.' limit 1) as is_save')
        )
        ->join('papers','papers.idpapers', '=', 'image.idpapers')
        ->join('users','users.id', '=', 'image.id')
        ->where('image.id', $id)
        ->orderBy('image.idimage', 'desc')
        ->limit($limit)
        ->get();
    }
    function scopeUserDesignSaved($query, $id, $limit)
    {
        return DB::table('bookmark')
        ->select(
            'image.idimage',
            'image.image as cover',
            'image.description',
            'image.width',
            'image.height',
            'papers.idpapers',
            'papers.created',
            'papers.title',
            'papers.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idimage = image.idimage) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idimage = image.idimage and bookmark.id = '.$id.' limit 1) as is_save')
        )
        ->join('image','image.idimage', '=', 'bookmark.idimage')
        ->join('papers','papers.idpapers', '=', 'image.idpapers')
        ->join('users','users.id', '=', 'image.id')
        ->where('bookmark.id', $id)
        ->orderBy('bookmark.idbookmark', 'desc')
        ->limit($limit)
        ->get();
    }
    function scopeSearchDesign($query, $ctr, $limit)
    {
        $id = 0;
        $searchValues = preg_split('/\s+/', $ctr, -1, PREG_SPLIT_NO_EMPTY);
        return DB::table('image')
        ->select(
            'image.idimage',
            'image.image as cover',
            'image.description',
            'image.width',
            'image.height',
            'papers.idpapers',
            'papers.created',
            'papers.title',
            'papers.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idimage = image.idimage) as ttl_save'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idimage = image.idimage and bookmark.id = '.$id.' limit 1) as is_save')
        )
        ->join('papers','papers.idpapers', '=', 'image.idpapers')
        ->join('users','users.id', '=', 'image.id')
        ->orWhere('papers.title','like',"%$ctr%")
        ->orWhere('papers.description','like',"%$ctr%")
        ->orWhere('image.description','like',"%$ctr%")
        ->orWhere('users.name','like',"%$ctr%")
        ->orWhere(function ($q) use ($searchValues)
        {
            foreach ($searchValues as $value) {
                $q->orWhere('papers.title','like',"%$value%");
                $q->orWhere('papers.description','like',"%$value%");
                $q->orWhere('image.description','like',"%$value%");
            }
        })
        ->orderBy('image.idimage', 'desc')
        ->limit($limit)
        ->get();
    }
}