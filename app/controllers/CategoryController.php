<?php

class CategoryController extends BaseController {

	/**
	 * Affiche les torrents selon la categorie
	 *
	 *
	 */
	public function category($slug, $id)
	{
		$category = Category::find($id);
		$torrents = $category->torrents()->paginate(20);

		return View::make('category.category', array('category' => $category, 'torrents' => $torrents));
	}

	/**
	 * Affiche la liste des catégories
	 *
	 * @access public
	 * @return View::make('category.categories')
	 */
	public function categories()
	{
		$categories = Category::all();

		return View::make('category.categories', array('categories' => $categories));
	}
}

?>
