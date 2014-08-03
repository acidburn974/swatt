<?php 

/**
 * Gestion des commentaires
 *
 *
 */
class CommentController extends BaseController {


	/**
	 * Ajoute un commentaire sur un article
	 *
	 */
	public function article($slug, $id)
	{
		$article = Article::find($id);
		$user = Auth::user();
		$comment = new Comment();
		$comment->content = Input::get('content');
		$comment->user_id = $user->id;
		$comment->article_id = $article->id;
		$v = Validator::make($comment->toArray(), array('content' => 'required', 'user_id' => 'required', 'article_id' => 'required'));
		if($v->passes())
		{
			$comment->save();
			Session::put('message', 'Your comment has been added');
		}
		else
		{
			Session::put('message', 'An error has occurred');
		}
		return Redirect::route('post', array('slug' => $article->slug, 'id' => $article->id));
	}

	/**
	 * Ajoute un commentaire sur un torrent
	 *
	 */
	public function torrent($slug, $id)
	{
		$torrent = Torrent::find($id);
		$user = Auth::user();
		$comment = new Comment();
		$comment->content = Input::get('content');
		$comment->user_id = $user->id;
		$comment->torrent_id = $torrent->id;
		$v = Validator::make($comment->toArray(), array('content' => 'required', 'user_id' => 'required', 'torrent_id' => 'required'));
		if($v->passes())
		{
			$comment->save();
			Session::put('message', 'Your comment has been added');
		}
		else
		{
			Session::put('message', 'An error has occurred');
		}
		return Redirect::route('torrent', array('slug' => $torrent->slug, 'id' => $torrent->id));
	}

	/**
	 * Retourne les commentaires sur l'article
	 *
	 *
	 */
	public function api_getComments()
	{
		if(Input::get('article_id'))
		{
			$article = Article::find(Input::get('article_id'));
			$comments = $article->comments;
		}
		else
		{
			$comments = Comment::all();
		}
		// Ajout de l'username
		foreach($comments as $k => $comment)
		{
			$comments[$k]['username'] = $comment->user->username;
		}
        return Response::json($comments);
	}

	public function api_postComments()
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
} ?>