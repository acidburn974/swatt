<?php  

namespace Admin;

use \View;
use \Request;
use \Input;
use \Auth;
use \Redirect;
use \Validator;

use \Illuminate\Support\Str;
use \Category;

class TorrentController extends \BaseController {

	/**
     * Affiche la page d'administration des articles
     *
     * @access public
     */
	public function index()
	{
		$torrents = \Torrent::all();
        return View::make('Admin.torrent.index', array('torrents' => $torrents));
	}

public function edit($slug, $id)
	{
		$tor = \Torrent::find($id);

		if(Request::isMethod('post'))
		{
			$id = Input::get('id');
			$name = Input::get('name');
			$torrent = \Torrent::find($id);
			$torrent->name = $name;
			$torrent->save();
			return Redirect::route('admin_torrent_index')->with('message', 'Torrent sucessfully modified');
		}

		return View::make('Admin.torrent.edit', array('tor' => $tor));
	}

} ?>