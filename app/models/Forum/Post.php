<?php

namespace Forum;

class Post extends \Eloquent {

	protected $table = 'forum_posts';

	public $rules = array(
		'content' => 'required',
		'user_id' => 'required',
		'thread_id' => 'required',
	);

	/**
	 * Belongs to User
	 *
	 */
	public function user()
	{
		return $this->belongsTo('\User');
	}

	/**
	 * Formate la sortie du contenu
	 *
	 */
	public function getContentHtml()
	{
		$code = new \Decoda\Decoda($this->content);
		$code->defaults();
		return $code->parse();
	}
} ?>
