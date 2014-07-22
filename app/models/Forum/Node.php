<?php 

namespace Forum;

class Node extends \Eloquent {

	/**
	 * Nom de la table dans la DB
	 *
	 */
	protected $table = 'forum_nodes';

	/**
	 * Has many Forum
	 *
	 */
	public function forums()
	{
		return $this->hasMany('\Forum\Forum');
	}
} ?>