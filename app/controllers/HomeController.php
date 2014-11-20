<?php

/**
 * Gestion des pages basiques
 *
 */
class HomeController extends BaseController {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Page d'accueil
	 *
	 * @access public
	 * @return View home.home
	 */
	public function home()
	{
		// Fetch latest articles
        $articles = Article::orderBy('created_at', 'DESC')->paginate(5);
		// Fetch latest torrents
		$torrents = Torrent::orderBy('created_at', 'DESC')->take(5)->get();
		// Fetch latest topics
		$topics = Topic::orderBy('created_at', 'DESC')->take(5)->get();
		// Fetch latest registered users
		$users = User::orderBy('created_at', 'DESC')->take(5)->get();

        return View::make('home.home', array('articles' => $articles, 'torrents' => $torrents, 'topics' => $topics, 'users' => $users));
	}

	/**
	 * Search for torrents
	 *
	 * @access public
	 * @return View page.torrents
	 *
	 */
	public function search()
	{
		// Only post request is accepted
		if(Request::isMethod('post'))
		{
			// Search terms
			$search = Input::get('search');
			// Fetch torrents that correspond the request
			$torrents = Torrent::where('name', 'LIKE', '%' . $search . '%')->paginate(20);

			return View::make('home.search', array('torrents' => $torrents));
		}
		else
		{
			// No post method
			return Redirect::to('/');
		}
	}

	/**
	 * Page de contact, envoie un email aux admins
	 *
	 * @access public
	 * @return View home.contact
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
			// Boucle d'envoie de mails
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
