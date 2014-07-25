<?php 

class Topic extends Eloquent {

	public $rules = array(
		'name' => 'required',
		'slug' => 'required',
		'state' => 'required',
		'num_post' => '',
		'first_post_user_id' => 'required',
		'first_post_user_username' => 'required',
		'last_post_user_id' => '',
		'last_post_user_username' => '',
		'views' => '',
		'pinned' => '',
		'forum_id' => 'required',
	);

	/**
	 * Belongs to Forum
	 * 
	 *
	 */
	public function forum()
	{
		return $this->belongsTo('Forum');
	}

	public function posts()
	{
		return $this->hasMany('Post');
	}
} ?>