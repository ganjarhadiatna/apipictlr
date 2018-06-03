<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Request;

//public
$router->group(['prefix' => 'api/'], function ($app) {
	/*auth*/
	$app->post('/login/', 'UserController@login');
	$app->post('/register/', 'UserController@register');

	/*Collections*/
	$app->get('/collections/all', 'CollectionController@getAll');

	/*search*/
	$app->get('/search/tag/{ctr}', 'TagController@tagSearch');
	$app->get('/search/design/{ctr}', 'DesignController@searchDesigns');
	$app->get('/search/paper/{ctr}', 'PaperController@searchPapers');
	$app->get('/search/user/{ctr}', 'UserController@searchUsers');

	/*explore*/
	$app->get('/explore', 'DesignController@freshDesigns');
	$app->get('/explore/fresh', 'DesignController@freshDesigns');
	$app->get('/explore/popular', 'DesignController@popularDesigns');
	$app->get('/explore/trending', 'DesignController@trendingDesigns');
	$app->get('/explore/news/{idtags}', 'DesignController@exploreDesignsByTag');

	/*Design*/
	$app->get('/design/{iddesign}', 'DesignController@view');
	$app->get('/design/{iddesign}/image', 'DesignController@image');
	$app->get('/design/{idpapers}/others', 'DesignController@other');
	$app->get('/design/{iddesign}/tags', 'TagController@tagDesign');
	$app->get('/design/{iddesign}/comments', 'CommentController@commentDesign');

	/*Paper*/
	$app->get('/paper/{idpapers}/design/{iddesign}', 'DesignController@view');
	$app->get('/paper/{idpapers}', 'PaperController@view');
	$app->get('/paper/{idpapers}/designs', 'PaperController@designs');
	$app->get('/paper/{idpapers}/detail', 'PaperController@detail');
	$app->get('/paper/{idpapers}/tags', 'TagController@tagPaper');

	/*tags*/
	$app->get('/tag/design/{ctr}', 'DesignController@tagDesigns');
	$app->get('/tag/popular', 'TagController@tagPopular');

	/*users*/
	$app->get('/user/{username}', 'UserController@getUserByUsername');
	$app->get('/user/{username}/papers', 'PaperController@getUserPapers');
	$app->get('/user/{username}/designs', 'DesignController@getUserDesigns');
});

//private
$router->group(['prefix' => 'api/', 'middleware' => 'auth'], function ($app) {
	//private informations
	$app->get('/my/data/{api_token}', 'UserController@getMyData');

	/*users*/
	$app->get('/user/{username}/saved', 'DesignController@getUserDesignsSaved');

	//paper
	$app->get('/', 'MainController@allPaper');

	/*Design on Paper*/
	$app->get('/timelines/{api_token}', 'DesignController@timelinesDesigns');

});