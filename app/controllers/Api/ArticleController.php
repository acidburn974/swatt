<?php 

namespace Api;

use View, Request, Input, Auth, Redirect, Validator, Response;

use Illuminate\Support\Str;
use Category, Torrent, Article, Comment;

class ArticleController extends \BaseController {

	/**
	 * Retourne les info JSON de l'article
	 *
	 */
	public function article($id = null)
	{
		 // Find de right post
        $post = Article::find($id);
        // Get comments on this post
        $comments = $post->comments()->orderBy('created_at', 'DESC')->get();
        return Response::json($post);
	}
} ?>