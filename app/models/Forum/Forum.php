<?php 

namespace Forum;

class Forum extends \Eloquent {

	/**
	 * Nom de la table dans la DB
	 *
	 */
	protected $table = 'forum_forums';

	/**
	 * Belongs to Node
	 *
	 */
	public function node()
	{
		return $this->belongsTo('\Forum\Node');
	}

	/**
	 * Has many Thread
	 *
	 */
	public function threads()
	{
		return $this->hasMany('\Forum\Thread');
	}
} ?>