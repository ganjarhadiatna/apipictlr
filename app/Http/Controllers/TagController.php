<?php

namespace App\Http\Controllers;

use App\TagModel;

/**
 * summary
 */
class TagController extends Controller
{
    /**
     * summary
     */
    function tagDesign($iddesign)
    {
    	$dt = TagModel::GetTag($iddesign, 'design');
    	return response()->json($dt);
    }
    function tagPaper($idpapers)
    {
    	$dt = TagModel::GetTag($idpapers, 'paper');
    	return response()->json($dt);
    }
    function tagPopular()
    {
        $dt = TagModel::PopularTag(5);
        return response()->json($dt);
    }
    function tagSearch($ctr)
    {
        $dt = TagModel::SearchTags(str_replace('%20', ' ', $ctr), 20);
        return response()->json($dt);
    }
}
