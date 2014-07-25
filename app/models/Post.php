<?php 

class Post extends Eloquent {

	public $rules = array(
		'content' => 'required',
		'user_id' => 'required',
		'topic_id' => 'required'
	);

	/**
	 * Belongs to Topic
	 *
	 *
	 */
	public function topic()
	{
		return $this->belongsTo('Topic');
	}

	/**
	 * Belongs to User
	 *
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Parle le content et retourne du HTML valide
	 *
	 */
	public function getContentHtml()
	{
		$code = new Decoda\Decoda($this->content);
		$code->defaults();
		return $code->parse();
	}
} ?>