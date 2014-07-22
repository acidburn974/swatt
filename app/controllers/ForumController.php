<?php

use \Forum\Node;
use \Forum\Forum;
use \Forum\Thread;
use \Forum\Post;
use Illuminate\Support\Str;

class ForumController extends BaseController {

	/**
	 * Affiche la page d'accueil du forum
	 *
	 */
	public function index()
	{
		$nodes = Node::all();
		return View::make('forum.index', array('nodes' => $nodes));
	}

	/**
	 * Affiche la node demandé avec les forums appartenant à cette categorie
	 *
	 * @access public
	 * @param $slug Slug de la catégorie (node)
	 * @param $id Id de la catégorie (node)
	 * @return void
	 */
	public function category($slug, $id)
	{
		$node = Node::find($id);
		$forums = $node->forums;

		return View::make('forum.category', array('node' => $node, 'forums' => $forums));
	}

	/**
	 * Affiche tout les threads(topics) dans le forum demandé
	 *
	 * @param $slug Slug du forum
	 * @param $id Id du forum
	 *
	 */
	public function display($slug, $id)
	{
		$forum = Forum::find($id);
		$category = $forum->node;
		$threads = $forum->threads()->orderBy('created_at', 'DESC')->get();

		return View::make('forum.display', array('forum' => $forum, 'category' => $category, 'threads' => $threads));
	}

	/**
	 * Démarre un nouveau sujet dans le forum choisie
	 *
	 * @param $id Id du forum
	 * @param $slug Slug du forum
	 *
	 */
	public function newThread($slug, $id)
	{
		$user = Auth::user();
		$forum = Forum::find($id);
		$category = $forum->node;
		if(Request::isMethod('post'))
		{
			$thread = new Thread();
			$thread->name = Input::get('title');
			$thread->slug = Str::slug($thread->name);
			$thread->num_post = 0;
			$thread->forum_id = $forum->id;
			$thread->user_id = $user->id;
			$vThread = Validator::make($thread->toArray(), $thread->rules);
			if($vThread->fails())
			{
				Session::put('message', 'An error has occurred');
			}
			else
			{
				$thread->save();
				$post = new Post();
				$post->content = Input::get('content');
				$post->user_id = $user->id;
				$post->thread_id = $thread->id;
				$vPost = Validator::make($post->toArray(), $post->rules);
				if($vPost->fails())
				{
					Session::put('message', 'An error has occurred when saving the post');
				}
				else
				{
					$post->save();
					$thread->num_post = $thread->posts()->count();
					$thread->save();
					return Redirect::route('forum_topic', array('slug' => $thread->slug, 'id' => $thread->id));
				}
			}
		}
		return View::make('forum.new_thread', array('forum' => $forum, 'category' => $category));
	}

	/**
	 * Affiche le thread demandé
	 *
	 * @param $slug Slug du thread
     * @param $id Id du thread
	 */
	public function topic($slug, $id)
	{
		$thread = Thread::find($id);
		$posts = $thread->posts;
		$forum = $thread->forum;
		$category = $forum->node;

		return View::make('forum.topic', array('thread' => $thread, 'posts' => $posts, 'forum' => $forum, 'category' => $category));
	}

	/**
	 * Ajoute une réponse au thread
	 *
	 * @access public
	 * @param $slug Slug du thread
	 * @param $id Id du thread
	 */
	public function response($slug, $id)
	{
		if(Request::isMethod('post'))
		{
			$user = Auth::user();
			$thread = Thread::find($id);
			$post = new Post();
			$post->content = Input::get('response');
			$post->user_id = $user->id;
			$post->thread_id = $thread->id;
			$v = Validator::make($post->toArray(), $post->rules);
			if($v->fails())
			{

			}
			else
			{
				$post->save();
				$thread->num_post = $thread->posts()->count();
				$thread->save();
			}
			return Redirect::route('forum_topic', array('slug' => $thread->slug, 'id' => $thread->id));
		}
	}
} ?>
