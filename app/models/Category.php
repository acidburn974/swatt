<?php

class Category extends Eloquent {

	public $timestamps = false;

	/**
	 * Règles de validation
	 *
	 */
	public $rules = array(
		'name' => 'required|unique:categories',
		'slug' => 'required|unique:categories',
		'image' => '',
		'description' => '',
	);

	/**
	 * Has many torrents
	 *
	 *
	 */
	public function torrents()
	{
		return $this->hasMany('Torrent');
	}

} ?>
