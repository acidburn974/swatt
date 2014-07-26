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

    /**
     * Affiche la page d'administration des articles
     *
     * @access public
     * @return post.admin_index_post
     */
    public function admin_indexPost()
    {
        $posts = Article::all();
        return View::make('post.admin_index_post', array('posts' => $posts));
    }

    /**
     * Ajoute un article
     *
     * @access public
     * @return post.admin_add_post
     */
    public function admin_addPost()
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
                return Redirect::route('admin_indexPost')->with('message', 'Your article has been published');
            }
        }
        return View::make('post.admin_add_post');
    }

    /**
     * Edite l'article voulu
     *
     * @access public
     * @param $slug Slug de l'article à édité
     * @param $id Id de l'article
     * @return post.admin_edit_post
     */
    public function admin_editPost($slug, $id)
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
                return Redirect::route('admin_indexPost')->with('message', 'Your article has been modified');
            }
        }
        return View::make('post.admin_edit_post', array('post' => $post));
    }

    /**
     * Supprime l'article désiré
     *
     * @access public
     * @param $slug Slug de l'article
     * @param $id Id de l'article
     * @return void
     */
    public function admin_deletePost($slug, $id)
    {
        $post = Article::find($id);
        $post->delete();
        return Redirect::route('admin_indexPost')->with('message', 'This article has been deleted');
    }
} ?>
