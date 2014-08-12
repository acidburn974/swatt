<?php 

namespace Api;

use View, Request, Input, Auth, Redirect, Validator, Response;

use Illuminate\Support\Str;
use Category, Torrent, Article, Comment;

class TorrentController extends \BaseController {

	/**
	 * Retourne les info JSON du torrent
	 *
	 */
	public function torrent($id)
	{
		// Find the right torrent
		$torrent = Torrent::find($id);
		// Format the description
		$torrent->descriptionHtml = $torrent->getDescriptionHtml();
		// Set username
		$torrent->username = $torrent->user->username;
		// Set user id
		$torrent->user_id = $torrent->user->id;
		// Define the size
		$torrent->size = $torrent->getSize();

		return Response::json($torrent);
	}
} ?>