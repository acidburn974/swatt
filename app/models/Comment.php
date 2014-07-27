<?php 

class Comment extends Eloquent {

	/**
	 * Belongs to Torrent
	 *
	 */
	public function torrent()
	{
		return $this->belongsTo('Torrent');
	}

	/**
	 * Belongs to Article
	 *
	 */
	public function article()
	{
		return $this->belongsTo('Article');
	}

	/**
	 * Belongs to User
	 *
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}
} ?>