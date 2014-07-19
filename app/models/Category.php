<?php

class Category extends Eloquent {

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
