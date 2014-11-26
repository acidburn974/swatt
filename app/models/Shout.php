<?php 

/**
 * Gestion des messages de la shoutbox
 *
 *
 */
class Shout extends Eloquent {


	public $rules = array(
		'content' => 'required',
	);

	public function user() {
		return $this->belongsTo('User');
	}
} ?>