<?php

class Tag extends Eloquent {

    public $timestamps = false;

    public $rules = array(
        'content' => 'required|unique:tags',
        'slug' => 'required|unique:tags',
    );

    /**
     * HABTM Torrent
     *
     *
     */
    public function torrents()
    {
        return $this->belongsToMany('Torrent');
    }
} ?>
