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
}
