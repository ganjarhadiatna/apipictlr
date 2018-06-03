<?php

namespace App\Http\Controllers;

use App\DesignModel;
use App\UserModel;
use App\WatchModel;
use App\TagModel;

/**
* 
*/
class DesignController extends Controller
{
	function view($iddesign)
	{
		$dt = DesignModel::DetailDesign($iddesign);
		return response()->json($dt);
	}
	function other($iddesign)
	{
		$dt = DesignModel::OtherDesign($iddesign);
		return response()->json($dt);
	}
	function image($iddesign)
	{
		$dt = DesignModel::ImageDesign($iddesign);
		return $dt;
	}
	function getUserDesigns($username)
	{
		$id = UserModel::GetId($username);
		$dt = DesignModel::UserDesign($id, $_GET['limit']);
		return response()->json($dt);
	}
	function getUserDesignsSaved($username)
	{
		$id = UserModel::GetId($username);
		$dt = DesignModel::UserDesignSaved($id, $_GET['limit']);
		return response()->json($dt);
	}

	/*public*/
	function exploreDesignsByTag($idtags)
	{
		$tag = TagModel::GetTagById($idtags);
		$dt = DesignModel::TagDesign($tag, $_GET['limit']);
        return response()->json($dt);
	}
	function tagDesigns($ctr)
    {
        $dt = DesignModel::TagDesign(str_replace('%20', ' ', $ctr), $_GET['limit']);
        return response()->json($dt);
    }
    function timelinesDesigns($api_token)
    {
        $id = UserModel::GetIdByToken($api_token);
        $papers = WatchModel::GetAllWatch($id);
        $dt = DesignModel::TimelinesDesign($_GET['limit'], $papers, $id);
        return response()->json($dt);
    }
	function freshDesigns()
	{
		$dt = DesignModel::FreshDesign($_GET['limit']);
		return response()->json($dt);
	}
	function popularDesigns()
	{
		$dt = DesignModel::PopularDesign($_GET['limit']);
		return response()->json($dt);
	}
	function trendingDesigns()
	{
		$dt = DesignModel::TrendingDesign($_GET['limit']);
		return response()->json($dt);
	}
	function searchDesigns($ctr)
	{
		$dt = DesignModel::SearchDesign(str_replace('%20', ' ', $ctr), $_GET['limit']);
		return response()->json($dt);
	}
}