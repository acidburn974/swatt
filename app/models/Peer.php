<?php 

class Peer extends Eloquent {
	
	public function user()
	{
		return $this->belongsTo('User');
	}
} ?>