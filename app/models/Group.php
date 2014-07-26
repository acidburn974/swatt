<?php
class Group extends Eloquent {

	public $timestamps = false;

	/**
	 * Has many users
	 *
	 */
	public function users()
	{
		return $this->hasMany('User');
	}

	/**
	 * Has many permissions
	 *
	 */
	public function permissions()
	{
		return $this->hasMany('Permission');
	}
} ?>
