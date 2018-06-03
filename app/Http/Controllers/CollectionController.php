<?php

namespace App\Http\Controllers;

use App\CollectionModel;
/**
 * summary
 */
class CollectionController extends Controller
{
    /**
     * summary
     */
    function getAll()
    {
    	$dt = CollectionModel::GetAll();
    	return response()->json($dt);
    }
}
