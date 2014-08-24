<?php

class Forum extends Eloquent {

	/**
	 * Has many topics
	 *
	 */
	public function topics()
	{
		return $this->hasMany('Topic');
	}

	/**
	 * Has many permissions
	 *
	 */
	public function permissions()
	{
		return $this->hasMany('Permission');
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

	/**
	 * Retourne le champ permission
	 *
	 */
	public function getPermission()
	{
		if(Auth::check())
		{
			$group = Auth::user()->group;
		}
		else
		{
			$group = Group::find(2);
		}
		return Permission::whereRaw('forum_id = ? AND group_id = ?', array($this->id, $group->id))->first();
	}
} ?>
