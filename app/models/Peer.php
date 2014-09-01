<?php
/**
 * Pairs pour les clients torrents
 *
 */
class Peer extends Eloquent {

	/**
	 * Belongs to User
	 *
	 *
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Belongs to torrent
	 *
	 *
	 */
	public function torrent()
	{
		return $this->belongsTo('Torrent');
	}
} ?>
