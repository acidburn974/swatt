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
        $articles = Article::orderBy('created_at', 'DESC')->paginate(5);

        return View::make('article.articles', array('articles' => $articles));
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
        $article = Article::find($id);
        // Get comments on this post
        $comments = $article->comments()->orderBy('created_at', 'DESC')->get();

        return View::make('article.article', array('article' => $article, 'comments' => $comments));
    }
} ?>
