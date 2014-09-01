<?php 
/**
 * Modèle relatif au fichiers de torrents
 *
 *
 */
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

	/**
	* Retourne la taille au format humain
	*
	*/
	public function getSize($bytes = null, $precision = 2)
	{
		$bytes = $this->size;
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);
		$bytes /= pow(1024, $pow);
		return round($bytes, $precision) . ' ' . $units[$pow];
	}
} ?>