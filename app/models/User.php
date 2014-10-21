<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * Modèle relatifs aux utilisateurs
 *
 *
 */
class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	public $rules = array(
		'username' => 'unique:users|required|alpha_num|min:3',
		'email' => 'unique:users|required|email',
		'password' => 'min:4|required'
	);

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	 * Belongs to group
	 *
	 */
	public function group()
	{
		return $this->belongsTo('Group');
	}

	/**
	 * Has many torrents
	 *
	 */
	public function torrents()
	{
		return $this->hasMany('Torrent');
	}

	/**
	* Has many peers
	*
	*/
	public function peers()
	{
		return $this->hasMany('Peer');
	}

	/**
	* Has many articles
	*
	*/
	public function articles()
	{
		return $this->hasMany('Article');
	}

	/**
	* Has many posts
	*
	*/
	public function posts()
	{
		return $this->hasMany('Post');
	}

	/**
	 * Has many Comment
	 *
	 */
	public function comments()
	{
		return $this->hasMany('Comment');
	}


	/**
	 * Retourne le upload au format humain
	 *
	 */
	public function getUploaded($bytes = null, $precision = 2)
	{
		$bytes = $this->uploaded;
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);
		$bytes /= pow(1024, $pow);
		return round($bytes, $precision) . ' ' . $units[$pow];
	}

	/**
	* Retourne le download au format humain
	*
	*/
	public function getDownloaded($bytes = null, $precision = 2)
	{
		$bytes = $this->downloaded;
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);
		$bytes /= pow(1024, $pow);
		return round($bytes, $precision) . ' ' . $units[$pow];
	}

	/**
	 * Retourne le ratio utilisateur
	 *
	 */
	public function getRatio()
	{
		return round($this->uploaded / $this->downloaded, 2);
	}

	/**
	 * Retourne le code HTML de la signature de l'utilisateur
	 *
	 * @access public
	 * @return string html
	 */
	public function getSignature()
	{
		$code = new Decoda\Decoda($this->signature);
		$code->defaults();
		$code->setXhtml(false);
		$code->setStrict(false);
		$code->setLineBreaks(true);
		return $code->parse();
	}
}
