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
	 * @param $slug Slug de l'article
	 * @param $id Id de l'article
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
	 * @param $slug Slug du torrent
	 * @param $id Id tu torrent
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
} ?>