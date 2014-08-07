<?php

namespace Admin;

use User;
use Torrent;
use Article;
use View;

class HomeController extends \BaseController {

	/**
	 * Affiche le dashboard
	 *
	 *
	 */
	public function home()
	{
		$num_user = User::all()->count();
		$num_article = Article::all()->count();
		$num_torrent = Torrent::all()->count();

		return View::make('Admin.home.home', array('num_user' => $num_user, 'num_torrent' => $num_torrent, 'num_article'=> $num_article));
	}

} ?>
