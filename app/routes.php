<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', ['uses' => 'HomeController@home', 'as' => 'home']);
Route::any('/search', ['uses' => 'HomeController@search', 'as' => 'search']);


// User
Route::any('/login', ['uses' => 'UserController@login', 'as' => 'login']);
Route::any('/signup', ['uses' => 'UserController@signup', 'as' => 'signup']);
Route::any('/logout', ['uses' => 'UserController@logout', 'before' => 'auth', 'as' => 'logout']);
Route::get('/members', ['uses' => 'UserController@members', 'as' => 'members']);
Route::get('/members/{username}.{id}', ['uses' => 'UserController@profil', 'as' => 'profil']);
Route::post('/members/{username}.{id}/photo', ['uses' => 'UserController@changePhoto', 'as' => 'user_change_photo', 'before' => 'auth']);


// Torrent
Route::get('/torrents', array('uses' => 'TorrentController@torrents', 'as' => 'torrents'));
Route::get('/torrents/{slug}.{id}', array('uses' => 'TorrentController@torrent', 'as' => 'torrent'));
Route::any('/upload', ['uses' => 'TorrentController@upload', 'before' => 'auth', 'as' => 'upload']);
Route::any('/announce/{passkey?}', ['uses' => 'TorrentController@announce', 'as' => 'announce']);
Route::get('/download/{slug}.{id}', ['uses' => 'TorrentController@download', 'as' => 'download',]);

// Category
Route::get('/categories', array('uses' => 'CategoryController@categories', 'as' => 'categories'));
Route::get('/categories/{slug}.{id}', ['uses' => 'CategoryController@category', 'as' => 'category']);

// Article
Route::get('/articles', array('uses' => 'ArticleController@articles', 'as' => 'articles'));
Route::get('/articles/{slug}.{id}', array('uses' => 'ArticleController@post', 'as' => 'post'));

// Commentaires
Route::any('/comment/article/{slug}.{id}', array('uses' => 'CommentController@article', 'as' => 'comment_article', 'before' => 'auth'));
Route::any('/comment/torrent/{slug}.{id}', array('uses' => 'CommentController@torrent', 'as' => 'comment_torrent', 'before' => 'auth'));

// Admin
Route::group(array('prefix' => 'admin', 'before' => 'auth|admin', 'namespace' => 'Admin'), function()
{
    Route::any('/', array('uses' => 'HomeController@home', 'as' => 'admin_home'));

    Route::any('/articles', array('uses' => 'ArticleController@index', 'as' => 'admin_article_index'));
    Route::any('/articles/new', array('uses' => 'ArticleController@add', 'as' => 'admin_article_add'));
    Route::any('/articles/edit/{slug}.{id}', array('uses' => 'ArticleController@edit', 'as' => 'admin_article_edit'));
    Route::any('/articles/delete/{slug}.{id}', array('uses' => 'ArticleController@delete', 'as' => 'admin_article_delete'));

    // ToDo
    Route::any('/members', array('uses' => 'UserController@admin_user_index', 'as' => 'admin_indexUser'));
    Route::any('/members/edit/{username}.{id}', array('uses' => 'UserController@admin_editUser', 'as' => 'admin_user_edit'));

    Route::any('/categories', array('uses' => 'CategoryController@index', 'as' => 'admin_category_index'));
    Route::any('/categories/new', array('uses' => 'CategoryController@add', 'as' => 'admin_category_add'));
    Route::any('/categories/edit/{slug}.{id}', array('uses' => 'CategoryController@edit', 'as' => 'admin_category_edit'));
    Route::any('/categories/delete/{slug}.{id}', array('uses' => 'CategoryController@delete', 'as' => 'admin_category_delete'));

    Route::get('/forums', array('uses' => 'ForumController@index', 'as' => 'admin_forum_index'));
    Route::any('/forums/new', array('uses' => 'ForumController@add', 'as' => 'admin_forum_add'));
    Route::any('/forums/edit/{slug}.{id}', array('uses' => 'ForumController@edit', 'as' => 'admin_forum_edit'));
    Route::get('/forums/delete/{slug}.{id}', array('uses' => 'ForumController@delete', 'as' => 'admin_forum_delete'));
});

// Forum
Route::get('/forums', function() { return Redirect::to('/community'); }); // Old link
Route::group(array('prefix' => 'community'), function()
{
    Route::get('/', array('uses' => 'ForumController@index', 'as' => 'forum_index'));
    Route::get('/category/{slug}.{id}', array('uses' => 'ForumController@category', 'as' => 'forum_category')); // Affiche la categorie
    Route::get('/forum/{slug}.{id}', array('uses' => 'ForumController@display', 'as' => 'forum_display')); // Affiche le forum et les topics
    Route::any('/forum/{slug}.{id}/new-topic', array('uses' => 'ForumController@newTopic', 'as' => 'forum_new_topic', 'before' => 'auth'));
    Route::get('/topic/{slug}.{id}', array('uses' => 'ForumController@topic', 'as' => 'forum_topic'));
    Route::any('/topic/{slug}.{id}/post-{postId}/edit', array('uses' => 'ForumController@postEdit', 'as' => 'forum_post_edit', 'before' => 'auth'));
    Route::post('/topic/{slug}.{id}/reply', array('uses' => 'ForumController@reply', 'as' => 'forum_reply', 'before' => 'auth'));
});
