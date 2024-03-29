<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To rou to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	$input = Input::get('search');
		$results = AdsInfo::where('ads_name', 'LIKE', '%'.$input.'%')->paginate(15);
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}
	public function getSearch()
	{
		$search = Input::get('search');
  		//$data = $this->AdsInfo->getByPage($page, 50);
		$results = AdsInfo::where('ads_name', 'LIKE', '%'.$search.'%')->paginate();

		return View::make('ilan.search-list', compact('search', 'results'));

	}
//http://njepuneere.loc/lib/search?sort=&page=2
}
