<?php

namespace Forum;

class Thread extends \Eloquent {

	protected $table = 'forum_threads';

	public $rules = array(
		'name' => 'required',
		'slug' => 'required',
		'num_post' => 'required',
		'forum_id' => 'required',
		'user_id' => 'required',
	);

	/**
	 * Belongs to Forum
	 *
	 */
	public function forum()
	{
		return $this->belongsTo('\Forum\Forum');
	}

	/**
	 * Has many Post
	 *
	 */
	public function posts()
	{
		return $this->hasMany('\Forum\Post');
	}

	/**
	 * Belongs to User
	 */
	public function user()
	{
		return $this->belongsTo('\User');
	}


} ?>
