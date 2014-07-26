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

	/**
	 * Affiche les categories
	 *
	 *
	 */
	public function admin_indexCategory()
	{
		$categories = Category::all();

		return View::make('category.admin_index_category', array('categories' => $categories));
	}

	/**
	 * Ajoute un cat
	 *
	 *
	 */
	public function admin_addCategory()
	{
		if(Request::isMethod('post'))
		{
			$category = new Category();
			$category->name = Input::get('name');
			$category->slug = Str::slug($category->name);
			$category->image = '';
			$category->description = Input::get('description');
			$v = Validator::make($category->toArray(), $category->rules);
			if($v->fails())
			{
				Session::put('message', 'An error has occurred');
			}
			else
			{
				$category->save();
				return Redirect::route('admin_indexCategory')->with('message', 'Category sucessfully added');
			}
		}
		return View::make('category.admin_add_category');
	}

	/**
	 * Edite une categorie
	 *
	 *
	 */
	public function admin_editCategory($slug, $id)
	{
		$category = Category::find($id);
		if(Request::isMethod('post'))
		{
			$category->name = Input::get('name');
			$category->slug = Str::slug($category->name);
			$category->image = '';
			$category->description = Input::get('description');
			$v = Validator::make($category->toArray(), $category->rules);
			if($v->fails())
			{
				Session::put('message', 'An error has occurred');
			}
			else
			{
				$category->save();
				return Redirect::route('admin_indexCategory')->with('message', 'Category sucessfully modified');
			}
		}

		return View::make('category.admin_edit_category', array('category' => $category));
	}

	public function admin_deleteCategory($slug, $id)
	{
		$category = Category::find($id);
		$category->delete();
		return Redirect::route('admin_indexCategory')->with('message', 'Category successfully deleted');
	}
}

?>
