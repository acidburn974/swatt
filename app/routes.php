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
Route::any('/contact', ['uses' => 'HomeController@contact', 'as' => 'contact']);

// User
Route::any('/login', ['uses' => 'UserController@login', 'as' => 'login']);
Route::any('/signup', ['uses' => 'UserController@signup', 'as' => 'signup']);
Route::any('/logout', ['uses' => 'UserController@logout', 'before' => 'auth', 'as' => 'logout']);
Route::get('/members', ['uses' => 'UserController@members', 'as' => 'members']);
Route::get('/members/{username}.{id}', ['uses' => 'UserController@profil', 'as' => 'profil']);
//Route::post('/members/{username}.{id}/edit', ['uses' => 'UserController@editProfil', 'as' => 'user_edit_profil', 'before' => 'auth']);
Route::post('/members/{username}.{id}/photo', ['uses' => 'UserController@changePhoto', 'as' => 'user_change_photo', 'before' => 'auth']);
Route::get('/members/{username}.{id}/activate/{token}', ['uses' => 'UserController@activate', 'as' => 'user_activate']);
Route::post('/members/{username}.{id}/about', ['uses' => 'UserController@changeAbout', 'as' => 'user_change_about', 'before' => 'auth']);

// RemindersController (Récupération de mot de passe)
Route::get('/lost-password', ['uses' => 'RemindersController@getRemind', 'as' => 'reminder_get_remind']);
Route::post('/lost-password', ['uses' => 'RemindersController@postRemind', 'as' => 'reminder_post_remind']);
Route::get('/password/reset/{token}', ['uses' => 'RemindersController@getReset', 'as' => 'reminder_get_passwordReset']);
Route::post('/password/reset', ['uses' => 'RemindersController@postReset', 'as' => 'reminder_post_passwordReset']);

// Page
Route::get('/p/{slug}.{id}', ['uses' => 'PageController@page', 'as' => 'page']);

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
Route::get('/articles/{slug}.{id}', array('uses' => 'ArticleController@post', 'as' => 'article'));

// Commentaires
Route::any('/comment/article/{slug}.{id}', array('uses' => 'CommentController@article', 'as' => 'comment_article', 'before' => 'auth'));
Route::any('/comment/torrent/{slug}.{id}', array('uses' => 'CommentController@torrent', 'as' => 'comment_torrent', 'before' => 'auth'));

// Admin
Route::group(array('prefix' => 'admin', 'before' => 'auth|admin', 'namespace' => 'Admin'), function()
{
    Route::any('/', array('uses' => 'HomeController@home', 'as' => 'admin_home'));

    // Articles
    Route::any('/articles', array('uses' => 'ArticleController@index', 'as' => 'admin_article_index'));
    Route::any('/articles/new', array('uses' => 'ArticleController@add', 'as' => 'admin_article_add'));
    Route::any('/articles/edit/{slug}.{id}', array('uses' => 'ArticleController@edit', 'as' => 'admin_article_edit'));
    Route::any('/articles/delete/{slug}.{id}', array('uses' => 'ArticleController@delete', 'as' => 'admin_article_delete'));

    // Torrent
    Route::any('/torrents', array('uses' => 'TorrentController@index', 'as' => 'admin_torrent_index'));
    Route::any('/torrents/edit/{slug}.{id}', array('uses' => 'TorrentController@edit', 'as' => 'admin_torrent_edit'));
    Route::get('/torrents/delete/{slug}.{id}', ['uses' => 'TorrentController@delete', 'as' => 'admin_torrent_delete']);

    // Users
    Route::any('/members', array('uses' => 'UserController@index', 'as' => 'admin_user_index'));
    Route::any('/members/edit/{username}.{id}', array('uses' => 'UserController@edit', 'as' => 'admin_user_edit'));

    // Categories
    Route::get('/categories', array('uses' => 'CategoryController@index', 'as' => 'admin_category_index'));
    Route::any('/categories/new', array('uses' => 'CategoryController@add', 'as' => 'admin_category_add'));
    Route::any('/categories/edit/{slug}.{id}', array('uses' => 'CategoryController@edit', 'as' => 'admin_category_edit'));
    Route::get('/categories/delete/{slug}.{id}', array('uses' => 'CategoryController@delete', 'as' => 'admin_category_delete'));

    // Forum
    Route::get('/forums', array('uses' => 'ForumController@index', 'as' => 'admin_forum_index'));
    Route::any('/forums/new', array('uses' => 'ForumController@add', 'as' => 'admin_forum_add'));
    Route::any('/forums/edit/{slug}.{id}', array('uses' => 'ForumController@edit', 'as' => 'admin_forum_edit'));
    Route::get('/forums/delete/{slug}.{id}', array('uses' => 'ForumController@delete', 'as' => 'admin_forum_delete'));

    Route::get('/pages', ['uses' => 'PageController@index', 'as' => 'admin_page_index']);
    Route::any('/pages/new', ['uses' => 'PageController@add', 'as' => 'admin_page_add']);
    Route::any('/pages/edit/{slug}.{id}', ['uses' => 'PageController@edit', 'as' => 'admin_page_edit']);
    Route::get('/pages/delete/{slug}.{id}', ['uses' => 'PageController@delete', 'as' => 'admin_page_delete']);
});

// Forum
Route::get('/forums', function() { return Redirect::to('/community'); }); // Old link
Route::group(array('prefix' => 'community'), function()
{
    Route::get('/', array('uses' => 'ForumController@index', 'as' => 'forum_index'));
    // Affiche la categorie
    Route::get('/category/{slug}.{id}', array('uses' => 'ForumController@category', 'as' => 'forum_category'));
    // Affiche le forum et les topics
    Route::get('/forum/{slug}.{id}', array('uses' => 'ForumController@display', 'as' => 'forum_display'));
    // Crée un nouveau topic
    Route::any('/forum/{slug}.{id}/new-topic', array('uses' => 'ForumController@newTopic', 'as' => 'forum_new_topic', 'before' => 'auth'));
    // Affiche le topic
    Route::get('/topic/{slug}.{id}', array('uses' => 'ForumController@topic', 'as' => 'forum_topic'));
    // Ferme le topic
    Route::get('/topic/{slug}.{id}/close', array('uses' => 'ForumController@closeTopic', 'as' => 'forum_close'));
    // Ouvre le topic
    Route::get('/topic/{slug}.{id}/open', array('uses' => 'ForumController@openTopic', 'as' => 'forum_open'));
    // Edit un post
    Route::any('/topic/{slug}.{id}/post-{postId}/edit', array('uses' => 'ForumController@postEdit', 'as' => 'forum_post_edit', 'before' => 'auth'));
    // Ajoute une réponse au topic
    Route::post('/topic/{slug}.{id}/reply', array('uses' => 'ForumController@reply', 'as' => 'forum_reply', 'before' => 'auth'));

    Route::any('/topic/{slug}.{id}/delete', array('uses' => 'ForumController@deleteTopic', 'as' => 'forum_delete_topic', 'before' => 'auth'));
});

// Api
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function(){

    // Affiche l'article
    Route::any('/article/{id}', 'ArticleController@article');
    // Affiche le torrent
    Route::any('/torrents/{id}', 'TorrentController@torrent');

    // Commentaire sur articles
    Route::get('/comments/article', 'CommentController@getArticleComments');
    Route::post('/comments/article', ['uses' => 'CommentController@addArticleComment', 'before' => 'auth']);

    // Commentaire sur torrents
    Route::get('/comments/torrent', 'CommentController@getTorrentComments');
    Route::post('/comments/torrent', ['uses' => 'CommentController@addTorrentComment', 'before' => 'auth']);

    // Affiches les topics dans le forum Like Display
    Route::get('/forums/display',  ['uses' => 'ForumController@display']);

    // Retourne le contenue BBCode en HTMl
    Route::post('/forums/preview', ['uses' => 'ForumController@getPreview']);
});
