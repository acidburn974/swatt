<?php

/**
 * Gestion des pages
 *
 */
class HomeController extends BaseController {

	/**
	 * Page d'accueil
	 *
	 */
	public function home()
	{
		$posts = Article::orderBy('created_at', 'DESC')->paginate(5);
		return View::make('home.home', array('posts' => $posts));
	}

	/**
	 * Search for torrents
	 *
	 *
	 */
	public function search()
	{
		if(Request::isMethod('post'))
		{
			$search = Input::get('search');
			$torrents = Torrent::where('name', 'LIKE', '%' . $search . '%')->paginate(20);
			return View::make('page.torrents', array('torrents' => $torrents));
		}
		else
		{
			return Redirect::to('/');
		}
	}

	/**
	 * Page de contact, envoie un email aux admins
	 *
	 *
	 */
	public function contact()
	{
		// Fetch le group admin
		$group = Group::where('slug', '=', 'administrators')->first();
		// Recup les admins
		$admins = User::where('group_id', '=', $group->id)->get();

		if(Request::getMethod() == 'POST')
		{
			$input = Input::all();
			foreach($admins as $user)
			{
				Mail::send('emails.contact', array('input' => $input), function($message) use ($user, $input) {
					$message->from($input['email'], Config::get('other.title'));
					$message->to($user->email, $user->username)->subject('New contact mail');
				});
			}
			Session::put('message', 'Your message was successfully send');
		}

		return View::make('home.contact');
	}
}
