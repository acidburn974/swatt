<?php 

namespace Admin;

use \View;
use \Request;
use \Input;
use \Auth;
use \Redirect;
use \Validator;

use \Illuminate\Support\Str;
use \Category;

class CategoryController extends \BaseController {

	/**
	 * Affiche les categories
	 *
	 *
	 */
	public function index()
	{
		$categories = Category::all();

		return View::make('Admin\category.index', array('categories' => $categories));
	}

	/**
	 * Ajoute un cat
	 *
	 *
	 */
	public function add()
	{
		if(Request::isMethod('post'))
		{
			$category = new Category();
			$category->name = Input::get('name');
			$category->slug = Str::slug($category->name);
			//$category->image = '';
			//$category->description = Input::get('description');
			$v = Validator::make($category->toArray(), $category->rules);
			if($v->fails())
			{
				Session::put('message', 'An error has occurred');
			}
			else
			{
				$category->save();
				return Redirect::route('admin_category_index')->with('message', 'Category sucessfully added');
			}
		}
		return View::make('Admin\category.add');
	}

	/**
	 * Edite une categorie
	 *
	 *
	 */
	public function edit($slug, $id)
	{
		$category = Category::find($id);
		if(Request::isMethod('post'))
		{
			$category->name = Input::get('name');
			$category->slug = Str::slug($category->name);
			//$category->image = '';
			//$category->description = Input::get('description');
			$v = Validator::make($category->toArray(), $category->rules);
			if($v->fails())
			{
				Session::put('message', 'An error has occurred');
			}
			else
			{
				$category->save();
				return Redirect::route('admin_category_index')->with('message', 'Category sucessfully modified');
			}
		}

		return View::make('Admin\category.edit', array('category' => $category));
	}

	public function delete($slug, $id)
	{
		$category = Category::find($id);
		$category->delete();
		return Redirect::route('admin_category_index')->with('message', 'Category successfully deleted');
	}

} ?>