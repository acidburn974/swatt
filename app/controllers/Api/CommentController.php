<?php 

namespace Api;

use View, Request, Input, Auth, Redirect, Validator, Response;

use Illuminate\Support\Str;
use Category, Torrent, Article, Comment;

class CommentController extends \BaseController {

	/**
	 * Retourne les commentaires sur l'article
	 */
	public function getArticleComments()
	{
		if(Input::get('article_id'))
		{
			$article = Article::find(Input::get('article_id'));
			$comments = $article->comments;
		}
		else
		{
			$comment = Comment::find($id);
		}
		// Ajout de l'username
		foreach($comments as $k => $comment)
		{
			$comments[$k]['username'] = $comment->user->username;
		}
        return Response::json($comments);
	}

	/**
	 * Ajoute un commentaire sur un article
	 */
	public function addArticleComment()
	{
		$user = Auth::user();
		$article = Article::find(Input::get('article_id'));
		$comment = new Comment();
		$comment->content = Input::get('content');
		$comment->article_id = $article->id;
		$comment->user_id = $user->id;
		$v = Validator::make($comment->toArray(), array('content' => 'required', 'user_id' => 'required', 'article_id' => 'required'));
		if($v->passes())
		{
			$comment->save();
		}
		else
		{
		}
	}

	/**
	 * Retourne en JSON les commentaires sur le torrent
	 *
	 */
	public function getTorrentComments($id = null)
	{
		$torrent = Torrent::find(Input::get('torrent_id'));

		$comments = $torrent->comments;
		foreach($comments as $k => $c)
		{
			$comments[$k]['username'] = $c->user->username;
		}

		return Response::json($comments);
	}

	/**
	 * Ajoute un commentaire sur le torrent
	 *
	 */
	public function addTorrentComment()
	{
		$user = Auth::user();
		$torrent = Torrent::find(Input::get('torrent_id'));
		$comment = new Comment();
		$comment->content = Input::get('content');
		$comment->torrent_id = $torrent->id;
		$comment->user_id = $user->id;
		$v = Validator::make($comment->toArray(), array('content' => 'required', 'user_id' => 'required', 'torrent_id' => 'required'));
		if($v->passes())
		{
			$comment->save();
		}
		else
		{
		}
	}

} ?>