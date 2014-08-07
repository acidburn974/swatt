<?php

namespace Admin;

use View;
use Request;
use Input;
use Auth;
use Redirect;
use Validator;
use Session;

use Illuminate\Support\Str;
use User;
use Group;

class UserController extends \BaseController {

	/**
	 * Affiche les membres du site
	 *
	 *
	 */
	public function index()
	{
		$users = User::orderBy('created_at', 'DESC')->paginate(20);

		return View::make('Admin.user.index', ['users' => $users]);
	}

	/**
	 * Edite un membre
	 *
	 *
	 */
	public function edit($username, $id)
	{
		$user = User::find($id);
		$groups = Group::all();

		if(Request::isMethod('post'))
		{
			$user->group_id = (int) Input::get('group_id');
			$user->about = Input::get('about');
			$user->save();
		}

		return View::make('Admin.user.edit', ['user' => $user, 'groups' => $groups]);
	}
} ?>
