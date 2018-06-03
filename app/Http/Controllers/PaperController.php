<?php

namespace App\Http\Controllers;

use App\DesignModel;
use App\PaperModel;
use App\UserModel;

/**
 * summary
 */
class PaperController extends Controller
{
    function designs($idpapers)
    {
    	$dt = DesignModel::PaperDesign($idpapers, $_GET['limit']);
		return response()->json($dt);
    }
    function detail($idpapers)
    {
    	$dt = PaperModel::DetailPaper($idpapers);
    	return response()->json($dt);
    }
    function getUserPapers($username)
    {
        $id = UserModel::GetId($username);
        $dt = PaperModel::UserPaper(20, $id);
        return response()->json($dt);
    }
    function searchPapers($ctr)
    {
        $dt = PaperModel::SearchPaper(str_replace('%20', ' ', $ctr), 20);
        return response()->json($dt);
    }
}
