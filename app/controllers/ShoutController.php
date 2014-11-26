<?php 

class ShoutController extends BaseController {

	/**
	 * Affiche la page de la shoutbox
	 *
	 *
	 * @access public
	 * @return view::make shout.index
	 */
	public function index() 
	{
		$shouts = Shout::orderBy('created_at', 'DESC')->take(10)->get()->reverse();

		return View::make('shout.index', array('shouts' => $shouts));
	}

	/**
	 * Ajoute un shout
	 *
	 * @access public
	 * @return redirect /shoutbox
	 */
	public function add() {
		$user = Auth::user();
		$shout = new Shout();
		$shout->content = Input::get('content');
		$shout->user_id = $user->id;
		$v = Validator::make($shout->toArray(), $shout->rules);

		if($v->passes()) {
			$shout->save();
		} else {

		}

		return Redirect::route('shoutbox');
	}
} ?>