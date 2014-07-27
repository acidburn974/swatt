<?php 

namespace Admin;

use \View;
use \Request;
use \Input;
use \Auth;
use \Redirect;
use \Validator;

use \Illuminate\Support\Str;
use \Article;

class ArticleController extends \BaseController {

	/**
     * Affiche la page d'administration des articles
     *
     * @access public
     * @return post.admin_index_post
     */
    public function index()
    {
        $posts = Article::all();
        return View::make('Admin\article.index', array('posts' => $posts));
    }

	/**
     * Ajoute un article
     *
     * @access public
     * @return post.admin_add_post
     */
    public function add()
    {
        if(Request::isMethod('post'))
        {
            $input = Input::all();
            $post = new Article();
            $post->title = $input['title'];
            $post->slug = Str::slug($post->title);
            $post->brief = $input['brief'];
            $post->content = $input['content'];
            //$post->user_id = Auth::user()->id;
            $v = Validator::make($post->toArray(), $post->rules);
            if($v->fails())
            {
                Session::put('message', 'An error has occured');
            }
            else
            {
                Auth::user()->articles()->save($post);
                return Redirect::route('admin_article_index')->with('message', 'Your article has been published');
            }
        }
        return View::make('Admin\article.add');
    }

    /**
     * Edite l'article voulu
     *
     * @access public
     * @param $slug Slug de l'article à édité
     * @param $id Id de l'article
     * @return post.admin_edit_post
     */
    public function edit($slug, $id)
    {
        $post =  Article::find($id);
        if(Request::isMethod('post'))
        {
            $input = Input::all();
            $post->title = $input['title'];
            $post->slug = Str::slug($post->title);
            $post->brief = $input['brief'];
            $post->content = $input['content'];
            //$post->user_id = Auth::user()->id;
            $v = Validator::make($post->toArray(), $post->rules);
            if($v->fails())
            {
                Session::put('message', 'An error has occured');
            }
            else
            {
                $post->save();
                return Redirect::route('admin_article_index')->with('message', 'Your article has been modified');
            }
        }
        return View::make('Admin\article.edit', array('post' => $post));
    }

    /**
     * Supprime l'article désiré
     *
     * @access public
     * @param $slug Slug de l'article
     * @param $id Id de l'article
     * @return void
     */
    public function delete($slug, $id)
    {
        $post = Article::find($id);
        $post->delete();
        return Redirect::route('admin_article_index')->with('message', 'This article has been deleted');
    }
} ?>