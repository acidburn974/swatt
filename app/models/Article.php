<?php

class Article extends Eloquent {
    
    public $rules = array(
        'title' => 'required',
        'slug' => 'required',
        'content' => 'required|min:100',
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

    /**
     * Retourne le contenue coupé pour la page d'accueil
     *
     * @access public
     * @param $length Longueur de la chaine
     * @param ellipses
     * @param strip_html Remove HTML tags from string
     * @return string Formatted and cutted content
     *
     */
    public function getBrief($length = 100, $ellipses = true, $strip_html = true)
    {
        $input = $this->content;
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }
      
        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }
      
        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);
      
        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }
      
        return $trimmed_text;
    }
} ?>
