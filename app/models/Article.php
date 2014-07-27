<?php

class Article extends Eloquent {

    public $rules = array(
        'title' => 'required',
        'slug' => 'required',
        'brief' => 'required',
        'content' => 'required',
        //'user_id' => 'required'
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
     * Has many Comment
     *
     */
    public function comments()
    {
        return $this->hasMany('Comment');
    }
} ?>
