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

Route::any('/login', ['uses' => 'UserController@login', 'as' => 'login']);
Route::any('/signup', ['uses' => 'UserController@signup', 'as' => 'signup']);
Route::any('/logout', ['uses' => 'UserController@logout', 'before' => 'auth', 'as' => 'logout']);
Route::get('/members', ['uses' => 'UserController@members', 'as' => 'members']);
Route::get('/members/{username}.{id}', ['uses' => 'UserController@profil', 'as' => 'profil']);

Route::get('/torrents', array('uses' => 'TorrentController@torrents', 'as' => 'torrents'));
Route::get('/torrents/{slug}.{id}', array('uses' => 'TorrentController@torrent', 'as' => 'torrent'));
Route::any('/upload', ['uses' => 'TorrentController@upload', 'before' => 'auth', 'as' => 'upload']);
Route::any('/announce/{passkey?}', ['uses' => 'TorrentController@announce', 'as' => 'announce']);
Route::get('/download/{slug}.{id}', ['uses' => 'TorrentController@download', 'before' => 'auth', 'as' => 'download',]);

Route::get('/categories', array('uses' => 'CategoryController@categories', 'as' => 'categories'));
Route::get('/categories/{slug}.{id}', ['uses' => 'CategoryController@category', 'as' => 'category']);

Route::get('/articles', array('uses' => 'PostController@articles', 'as' => 'articles'));
Route::get('/articles/{slug}.{id}', array('uses' => 'PostController@post', 'as' => 'post'));

Route::group(array('prefix' => 'admin', 'before' => 'auth|admin'), function()
{
    Route::any('/', array('uses' => 'HomeController@admin_home', 'as' => 'admin_home'));

    Route::any('/articles', array('uses' => 'PostController@admin_indexPost', 'as' => 'admin_indexPost'));
    Route::any('/articles/new', array('uses' => 'PostController@admin_addPost', 'as' => 'admin_addPost'));
    Route::any('/articles/edit/{slug}.{id}', array('uses' => 'PostController@admin_editPost', 'as' => 'admin_editPost'));
    Route::any('/articles/delete/{slug}.{id}', array('uses' => 'PostController@admin_deletePost', 'as' => 'admin_deletePost'));

    // ToDo
    Route::any('/members', array('uses' => 'UserController@admin_indexUser', 'as' => 'admin_indexUser'));
    Route::any('/members/edit/{username}.{id}', array('uses' => 'UserController@admin_editUser', 'as' => 'admin_editUser'));

    Route::any('/categories', array('uses' => 'CategoryController@admin_indexCategory', 'as' => 'admin_indexCategory'));
    Route::any('/categories/new', array('uses' => 'CategoryController@admin_addCategory', 'as' => 'admin_addCategory'));
    Route::any('/categories/edit/{slug}.{id}', array('uses' => 'CategoryController@admin_editCategory', 'as' => 'admin_editCategory'));
    Route::any('/categories/delete/{slug}.{id}', array('uses' => 'CategoryController@admin_deleteCategory', 'as' => 'admin_deleteCategory'));
});
