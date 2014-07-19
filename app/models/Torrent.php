<?php

class Torrent extends Eloquent {

	/**
	 * Règles de validation
	 *
	 */
	public $rules = array(
		'name' => 'required',
		'slug' => 'required',
		'description' => 'required',
		'info_hash' => 'required|unique:torrents',
		'file_name' => 'required',
		'file_count' => 'required|numeric',
		'announce' => 'required',
		'size' => 'required',
		//'nfo' => 'required',
		'created_by' => 'required',
		'category_id' => 'required',
		'user_id' => 'required',
	);

	/**
	 * Belongs to User
	 *
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Belongs to  Category
	 *
	 */
	public function category()
	{
		return $this->belongsTo('Category');
	}

	/**
	 * Has many files
	 *
	 */
	public function files()
	{
		return $this->hasMany('TorrentFile');
	}

	/**
	 * Formate la sortie de la description
	 *
	 */
	public function getDescriptionHtml()
	{
		$code = new Decoda\Decoda($this->description);
		$code->defaults();
		return $code->parse();
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
