<?php  

namespace Admin;

class HomeController extends \BaseController {

	/**
	 * Affiche le dashboard
	 *
	 *
	 */
	public function home()
	{
		$user = \User::orderBy('id', 'DESC')->first();
		$torrent = \Torrent::orderBy('id', 'DESC')->first();
		$post = \Post::orderBy('id', 'DESC')->first();
		$users = $user->id;
		$torrents = $torrent->id;
			if($post == false){

				$post = 0;
			}
			else {
				$post = $post->id;
			}
		$posts = $post;

		return \View::make('Admin.home.home', array('users'=>$users, 'torrents'=>$torrents, 'posts'=>$posts));
	}

} ?>