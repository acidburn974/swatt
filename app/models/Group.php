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

	/**
	* Retourne la row demandé de la table des permissions
	*
	*/
	public function getPermissionsByForum($forum)
	{
		return Permission::whereRaw('forum_id = ? AND group_id = ?', array($forum->id, $this->id))->first();
	}
} ?>
