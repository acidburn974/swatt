<?php 
class TorrentFile extends Eloquent {

	/**
	 * Nom de la table dans la DB
	 *
	 */
	protected $table = 'files';

	/**
	 * Désactive les dates lors de la sauvegarde
	 *
	 */
	public $timestamps = false;

	/**
	 * Belongs to Torrent
	 *
	 *
	 */
	public function torrent() 
	{
		return $this->belongsTo('Torrent');
	}
} ?>