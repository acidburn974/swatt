<?php   

namespace Admin;

use View, Request, Input, Auth, Redirect, Validator, Session;
use Illuminate\Support\Str;
use Page;

class PageController extends \BaseController {

	/**
	 * Affiche les pages d'index
	 *
	 *
	 */
	public function index()
	{
		$pages = Page::all();

		return View::make('Admin.page.index', ['pages' => $pages]);
	}

	/**
	 * Ajoute une page
	 *
	 *
	 */
	public function add()
	{
		if(Request::getMethod() == 'POST')
		{
			$page = new Page();
			$page->name = Input::get('name');
			$page->slug = Str::slug($page->name);
			$page->content = Input::get('content');

			$v = Validator::make($page->toArray(), ['name' => 'required', 'slug' => 'required', 'content' => 'required']);
			if($v->passes())
			{
				$page->save();
				return Redirect::route('admin_page_index');
			}
			else
			{
				Session::put('message', 'An error has occurred');
			}
		}
		return View::make('Admin.page.add');
	}

	/**
	 * Edit une page
	 *
	 *
	 */
	public function edit($slug, $id)
	{
		$page = Page::find($id);
		if(Request::getMethod() == 'POST')
		{
			$page->name = Input::get('name');
			$page->slug = Str::slug($page->name);
			$page->content = Input::get('content');

			$v = Validator::make($page->toArray(), ['name' => 'required', 'slug' => 'required', 'content' => 'required']);
			if($v->passes())
			{
				$page->save();
				return Redirect::route('admin_page_index')->with('message', 'Page edited successfully');
			}
			else
			{
				Session::put('message', 'An error has occurred');
			}
		}
		return View::make('Admin.page.edit', ['page' => $page]);
	}

	/**
	 * Delete une page
	 *
	 *
	 */
	public function delete($slug, $id)
	{
		Page::find($id)->delete();
		return Redirect::route('admin_page_index')->with('message', 'Page successfully deleted');
	}
} ?>