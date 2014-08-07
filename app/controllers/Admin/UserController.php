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

class UserController extends BaseController {

	/**
	 * Affiche les membres du site
	 *
	 *
	 */
	public function index() {
		$users = User::orderBy('created_at', 'DESC')->painate(20);
		
		return View::make('Admin.user.index', ['users' => $users]);
	}

	/**
	 * Edite un membre
	 *
	 *
	 */
	public function edit($username, $id) {

	}
} ?>