<?php

namespace App\Http\Controllers;

use App\CommentModel;

/**
 * summary
 */
class CommentController extends Controller
{
    /**
     * summary
     */
    function commentDesign($iddesign)
    {
    	$dt = CommentModel::GetComment($iddesign, 0, 10);
    	return response()->json($dt);
    }
}
