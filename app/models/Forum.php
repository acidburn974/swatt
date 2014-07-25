<?php 

class Forum extends \Eloquent {

	/**
	 * Has many topics
	 *
	 */
	public function topics()
	{
		return $this->hasMany('Topic');
	}

	/**
	 * Retourne un tableau avec les forums dans la catégorie
	 *
	 */
	public function getForumsInCategory()
	{
		return Forum::where('parent_id', '=', $this->id)->get();
	}

	/**
	 * Retourne la categorie dans laquel se trouve le forum
	 *
	 */
	public function getCategory()
	{
		return Forum::find($this->parent_id);
	}

	/**
	 * Compte le nombre de post dans le forum
	 *
	 *
	 */
	public function getPostCount($forumId)
	{
		$forum = Forum::find($forumId);
		$topics = $forum->topics;
		$count = 0;
		foreach($topics as $t)
		{
			$count += $t->posts()->count();
		}
		return $count;
	}

	/**
	 * Compte le nombre de topic dans le forum
	 *
	 */
	public function getTopicCount($forumId)
	{
		$forum = Forum::find($forumId);
		return Topic::where('forum_id', '=', $forum->id)->count();
	}
} ?>