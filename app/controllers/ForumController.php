<?php

use Illuminate\Support\Str;

class ForumController extends BaseController {

	/**
	 * Affiche la page d'accueil du forum
	 *
	 */
	public function index()
	{
		$categories = Forum::where('parent_id', '=', 0)->orderBy('position', 'ASC')->get();
		return View::make('forum.index', array('categories' => $categories));
	}

	/**
	 * Affiche la catégorie demandé
	 *
	 * @access public
	 * @param $slug Slug de la catégorie
	 * @param $id Id de la catégorie
	 * @return void
	 */
	public function category($slug, $id)
	{
		$category = Forum::find($id);
		return View::make('forum.category', array('c' => $category));
	}

	/**
	 * Affiche le forums et les topics à l'intérieur
	 *
	 *
	 */
	public function display($slug, $id)
	{
		$forum = Forum::find($id);
		if($forum->parent_id == 0)
		{
			return Redirect::route('forum_category', array('slug' => $forum->slug, 'id' => $forum->id));
		}
		$category = Forum::find($forum->parent_id);
		$topics = $forum->topics()->orderBy('created_at', 'DESC')->paginate();

		return View::make('forum.display', array('forum' => $forum, 'topics' => $topics, 'category' => $category));
	}

	/**
	 * Affiche le topic
	 *
	 *
	 */
	public function topic($slug, $id)
	{
		$topic = Topic::find($id);
		$forum = $topic->forum;
		$category = $forum->getCategory();
		$posts = $topic->posts;

		//$topic->views++;
		//$topic->save();

		return View::make('forum.topic', array('topic' => $topic, 'forum' => $forum, 'category' => $category, 'posts' => $posts));
	}

	/**
	 * Ajoute une réponse à un topic
	 *
	 * @param $slug Slug du topic
	 * @param $id Id du topic
	 */
	public function reply($slug, $id)
	{
		$user = Auth::user();
		$topic = Topic::find($id);
		$forum = $topic->forum;
		$category = $forum->getCategory();

		$post = new Post();
		$post->content = Input::get('content');
		$post->user_id = $user->id;
		$post->topic_id = $topic->id;

		$v = Validator::make($post->toArray(), array(
			'content' => 'required',
			'user_id' => 'required',
			'topic_id' => 'required'
			)
		);
		if($v->passes())
		{
			$post->save();

			$topic->last_post_user_id = $user->id;
			$topic->last_post_user_username = $user->username;
			$topic->num_post = Post::where('topic_id', '=', $topic->id)->count();
			$topic->save();

			/** Compte les topics dans ce forum */
			$forum->num_post = $forum->getPostCount($forum->id);
			$forum->num_topic = $forum->getTopicCount($forum->id);
			$forum->save();

			return Redirect::route('forum_topic', array('slug' => $topic->slug, 'id' => $topic->id));
		}	
	}

	/**
	 * Crée un nouveau topic dans le forum désiré
	 *
	 * @param $slug Slug du forum dans lequel sera le topic
	 * @param $id Id du forum dans lequel sera le topic
	 */
	public function newTopic($slug, $id)
	{
		$user = Auth::user();
		$forum = Forum::find($id);
		$category = $forum->getCategory();
		$parsedContent = null;

		// Prévisualisation du post
		if(Request::getMethod() == 'POST' && Input::get('preview') == true)
		{
			$code = new Decoda\Decoda(Input::get('content'));
			$code->defaults();
			$parsedContent = $code->parse();
		}
		
		if(Request::getMethod() == 'POST' && Input::get('post') == true)
		{
			// Crée le topic
			$topic = new Topic();
			$topic->name = Input::get('title');
			$topic->slug = Str::slug(Input::get('title'));
			$topic->state = "open";
			$topic->first_post_user_id = $user->id;
			$topic->first_post_user_username = $user->username;
			$topic->last_post_user_id = $user->id;
			$topic->last_post_user_username = $user->username;
			$topic->views = 0;
			$topic->pinned = false;
			$topic->forum_id = $forum->id;
			$v = Validator::make($topic->toArray(), $topic->rules);
			if($v->passes())
			{
				$topic->save();

				$post = new Post();
				$post->content = Input::get('content');
				$post->user_id = $user->id;
				$post->topic_id = $topic->id;
				$v = Validator::make($post->toArray(), $post->rules);
				if($v->passes())
				{
					$post->save();
					$topic->num_post = 1;
					$topic->save();
					$forum->num_topic = $forum->getTopicCount($forum->id);
					$forum->num_post = $forum->getPostCount($forum->id);
					$forum->save();
					return Redirect::route('forum_topic', array('slug' => $topic->slug, 'id' => $topic->id));
				}
				else
				{
					// Impoossible de save le premier post donc delete le topic
					$topic->delete();
				}
			}
			else
			{

			}
		}

		return View::make('forum.new_topic', array('forum' => $forum, 'category' => $category, 'parsedContent' => $parsedContent, 'title' => Input::get('title'), 'content' => Input::get('content')));
	}
} ?>
