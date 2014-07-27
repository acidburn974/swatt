<?php  

namespace Admin;

class HomeController extends \BaseController {

	/**
	 * Affiche le dashboard
	 *
	 *
	 */
	public function home()
	{
		return \View::make('Admin.home.home');
	}
} ?>