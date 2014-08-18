<?php 


class PageController extends BaseController {

	/**
	* Affiche la page demandé
	*
	*
	*/
	public function page($slug, $id)
	{
		$page = Page::find($id);

		return View::make('page.page', ['page' => $page]);
	}
} ?>