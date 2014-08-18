<?php

class BaseController extends Controller {

	/** 
	* Constructeur
	*
	*
	*/
	public function __construct()
	{	
		// Récupère les pages pour l'affichage dans le layout
		View::share('pages', Page::all());
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
}
