<?php 
class Group extends Eloquent {

	/**
	 * Has many users
	 *
	 */
	public function users()
	{
		return $this->hasMany('User');
	}
} ?>