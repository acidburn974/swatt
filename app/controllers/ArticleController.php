<?php

use Illuminate\Support\Str;

class ArticleController extends BaseController {

    /**
     * Affiche les articles comme en page d'accueil
     *
     * @access public
     * @return post.articles
     */
    public function articles()
    {
        $posts = Article::orderBy('created_at', 'DESC')->paginate(5);
        return View::make('post.articles', array('posts' => $posts));
    }

    /**
     * Affiche l'article
     *
     * @access public
     * @return post.post
     */
    public function post($slug, $id)
    {
        $post = Article::find($id);

        return View::make('post.post', array('post' => $post));
    }

} ?>
