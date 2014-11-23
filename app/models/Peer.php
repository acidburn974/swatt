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

	/**
	 * Delete all old peers from database
	 *
	 *
	 */
	public static function deleteOldPeers()
	{
		// Deleting old peers from the database
		foreach(Peer::all() as $peer)
		{
			if((time() - strtotime($peer->updated_at)) > (10 * 60))
			{
				$peer->delete();
			}
		}
		return true;
	}
} ?>
