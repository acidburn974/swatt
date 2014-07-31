<?php

/**
 * Gestion des pages
 *
 */
class HomeController extends BaseController {

	/**
	 * Page d'accueil
	 *
	 */
	public function home()
	{
		$posts = Article::orderBy('created_at', 'DESC')->paginate(5);
		return View::make('home.home', array('posts' => $posts));
	}

	/**
	 * Search for torrents
	 *
	 *
	 */
	public function search()
	{
		if(Request::isMethod('post'))
		{
			$search = Input::get('search');
			$torrents = Torrent::where('name', 'LIKE', '%' . $search . '%')->get();
			return View::make('page.torrents', array('torrents' => $torrents));
		}
		else
		{
			return Redirect::to('/');
		}
	}
}
