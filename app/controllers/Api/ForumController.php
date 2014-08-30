<?php

namespace Api;

use View, Request, Input, Auth, Redirect, Validator, Response;
use Forum, Topic;

class ForumController extends \BaseController {
    /**
     * Retourne les topics dans le forum
     *
     * @access public
     * @param Int $id Id du forum
     *
     */
    public function display()
    {
        $forum = Forum::find(Input::get('forum_id'));
        $topics = $forum->topics;

        return Response::json($topics);
    }


    /**
     * Affiche le contenue 
     *
     * @access public
     * @return HTML
     */
    public function getPreview()
    {
        $code = new Decoda\Decoda(Input::get('content'));
        $code->defaults();
        $code->setXhtml(false);
        $code->setStrict(false);
        $code->setLineBreaks(true);
        return $code->parse();
    }
}?>
