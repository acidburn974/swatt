<?php

class Permission extends Eloquent {

    public $timestamps = false;

    /**
     * Belongs to group
     *
     */
    public function group()
    {
        return $this->belongsTo('Group');
    }

    /**
     * Belongs to Forum
     *
     *
     */
    public function forum()
    {
        return $this->belongsTo('Forum');
    }
} ?>
