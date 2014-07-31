<?php

use Illuminate\Support\Str;

/**
 * Gestion des articles
 *
 */
class ArticleController extends BaseController {

    /**
     * Affiche les articles comme en page d'accueil
     *
     * @access public
     * @return post.articles
     */
    public function articles()
    {
        // Fetch posts by created_at DESC order
        $posts = Article::orderBy('created_at', 'DESC')->paginate(5);

        return View::make('article.articles', array('posts' => $posts));
    }

    /**
     * Affiche l'article
     *
     * @access public
     * @return post.post
     */
    public function post($slug, $id)
    {
        // Find de right post
        $post = Article::find($id);
        // Get comments on this post
        $comments = $post->comments()->orderBy('created_at', 'DESC')->get();

        return View::make('article.post', array('post' => $post, 'comments' => $comments));
    }

} ?>
