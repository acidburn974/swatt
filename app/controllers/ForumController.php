<?php

use Illuminate\Support\Str;

/**
 * Gestion du forum
 *
 */
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
		if($category->getPermission()->show_forum != true)
		{
			return Redirect::route('forum_index')->with('message', 'You haven\'t access to this category');
		}
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
		// Permission
		if($category->getPermission()->show_forum != true)
		{
			return Redirect::route('forum_index')->with('message', 'You haven\'t access to this forum');
		}
		$topics = $forum->topics()->orderBy('created_at', 'DESC')->paginate();

		return View::make('forum.display', array('forum' => $forum, 'topics' => $topics, 'category' => $category));
	}

	/**
	 * Show the topic
	 *
	 * @param $slug Slug du  topic
	 * @param $id Id du topic
	 */
	public function topic($slug, $id)
	{
		// Find the topic
		$topic = Topic::find($id);

		// Get the forum of the topic
		$forum = $topic->forum;

		// Get The category of the forum
		$category = $forum->getCategory();

		// Get all posts
		$posts = $topic->posts()->paginate(20);

		// The user can post a topic here ?
		if($category->getPermission()->read_topic != true)
		{
			// Redirect him to the forum index
			return Redirect::route('forum_index')->with('message', 'You can\'t read this topic');
		}

		// Increment view
		$topic->views++;
		$topic->save();

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

		// L'utilisateur possède le droit de crée un topic ici
		if($category->getPermission()->reply_topic != true)
		{
			return Redirect::route('forum_index')->with('message', 'You can\'t reply this topic');
		}

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
			// Save the reply
			$post->save();
			// Save last post user data to topic table
			$topic->last_post_user_id = $user->id;
			$topic->last_post_user_username = $user->username;
			// Count post i topic
			$topic->num_post = Post::where('topic_id', '=', $topic->id)->count();
			// Save
			$topic->save();

			// Count posts
			$forum->num_post = $forum->getPostCount($forum->id);
			// Count topics
			$forum->num_topic = $forum->getTopicCount($forum->id);
			// Save last post user data to the forum table
			$forum->last_post_user_id = $user->id;
			$forum->last_post_user_username = $user->username;
			// Save
			$forum->save();

			// Find the user who initated the topic
			$topicCreator = User::find($topic->first_post_user_id);

			// Envoie un mail pour signaler un nouveau message dans le topic
			Mail::send('emails.new_reply', array('user' => $user, 'topic' => $topic), function($message) use ($user, $topic, $topicCreator) {
				$message->from(Config::get('other.email'), Config::get('other.title'));
                $message->to($topicCreator->email, '')->subject('The topic ' . $topic->name . ' has a new reply');
			});

			return Redirect::route('forum_topic', array('slug' => $topic->slug, 'id' => $topic->id));
		}
		else
		{
			return Redirect::route('forum_topic', array('slug' => $topic->slug, 'id' => $topic->id))->with('message', 'This reply can\'t be posted');
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

		// L'utilisateur possède le droit de crée un topic ici
		if($category->getPermission()->start_topic != true)
		{
			return Redirect::route('forum_index')->with('message', 'You can\'t start a new topic here');
		}

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
			$topic->state = 'open';
			$topic->first_post_user_id = $topic->last_post_user_id = $user->id;
			$topic->first_post_user_username = $topic->last_post_user_username = $user->username;
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
					$forum->last_topic_id = $topic->id;
					$forum->last_topic_name = $topic->name;
					$forum->last_topic_slug = $topic->slug;
					$forum->last_post_user_id = $user->id;
					$forum->last_post_user_username = $user->username;
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

	/**
	 * Edit le post de l'utilisateur
	 *
	 * @param $slug Slug du topic
	 * @param $id Id du topic
	 * @param $postId Id du post
	 */
	public function postEdit($slug, $id, $postId)
	{
		$user = Auth::user();
		$topic = Topic::find($id);
		$forum = $topic->forum;
		$category = $forum->getCategory();
		$post = Post::find($postId);
		$parsedContent = null;

		if($user->group->is_modo == false)
		{
			if($post->user_id != $user->id)
			{
				return Redirect::route('forum_topic', ['slug' => $topic->slug, 'id' => $topic->id])->with('message', 'You can\'t edit this post');
			}
		}

		// Prévisualisation du post
		if(Request::getMethod() == 'POST' && Input::get('preview') == true)
		{
			$post->content = Input::get('content');
			$code = new Decoda\Decoda($post->content);
			$code->defaults();
			$parsedContent = $code->parse();
		}

		if(Request::isMethod('post') && Input::get('post') == true)
		{
			$post->content = Input::get('content');
			$post->save();
			return Redirect::route('forum_topic', ['slug' => $topic->slug, 'id' => $topic->id]);
		}
		return View::make('forum.post_edit', ['user' => $user, 'topic' => $topic, 'forum' => $forum, 'post' => $post, 'category' => $category, 'parsedContent' => $parsedContent]);
	}

	/**
	 * Ferme le topic
	 *
	 *
	 */
	public function closeTopic($slug,$id)
	{
		$topic = Topic::find($id);
		$topic->state = "close";
		$topic->save();

		return Redirect::route('forum_topic', ['slug' => $topic->slug, 'id' => $topic->id])->with('message', 'This topic is now closed');
	}

	/**
	 * Ouvre le topic
	 *
	 */
	public function openTopic($slug,$id)
	{
		$topic = Topic::find($id);
		$topic->state = "open";
		$topic->save();
		return Redirect::route('forum_topic', ['slug' => $topic->slug, 'id' => $topic->id])->with('message', 'This topic is now open');
	}

	/**
	 * Delete le topic et les posts associées
	 *
	 */
	public function deleteTopic($slug, $id)
	{
		$user = Auth::user();
		$topic = Topic::find($id);
		if($user->group->is_modo == true)
		{
			$posts = $topic->posts();
			$posts->delete();
			$topic->delete();
			return Redirect::route('forum_display', ['slug' => $topic->forum->slug, 'id' => $topic->forum->id])->with('message', 'Topic sucessfully deleted');
		}
		else
		{
			return Redirect::route('forum_topic', ['slug' => $topic->slug, 'id' => $topic->id])->with('message', 'You haven\'t access to this functionality');
		}
	}
} ?>
