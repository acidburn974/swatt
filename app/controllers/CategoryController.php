<?php

use Illuminate\Support\Str;

class CategoryController extends BaseController {

	/**
	 * Affiche les torrents selon la categorie
	 *
	 * @access public
	 * @param $slug Slug de la categorie
	 * @param $id Id de la catégorie
	 * @return category.category View
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
	 * @return category.categories View
	 */
	public function categories()
	{
		$categories = Category::all();

		return View::make('category.categories', array('categories' => $categories));
	}
}

?>
