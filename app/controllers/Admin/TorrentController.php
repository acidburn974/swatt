<?php  

namespace Admin;

use View;
use Request;
use Input;
use Auth;
use Redirect;
use Validator;

use Illuminate\Support\Str;
use Category;
use Torrent;

class TorrentController extends \BaseController {

	/**
     * Affiche la page d'administration des articles
     *
     * @access public
     */
	public function index()
	{
		$torrents = Torrent::all();
        return View::make('Admin.torrent.index', array('torrents' => $torrents));
	}

	public function edit($slug, $id)
	{
		$torrent = Torrent::find($id);

		if(Request::isMethod('post'))
		{
			$name = Input::get('name');

			$torrent->name = $name;
			$torrent->description = Input::get('description');
			$torrent->save();
			return Redirect::route('admin_torrent_index')->with('message', 'Torrent sucessfully modified');
		}

		return View::make('Admin.torrent.edit', array('tor' => $torrent));
	}

	public function delete($slug, $id)
	{
		$torrent = Torrent::find($id);

		foreach($torrent->files as $f)
		{
			$f->delete();
		}

		if(file_exists(getcwd() . '/files/torrents/' . $torrent->file_name))
		{
			unlink(getcwd() . '/files/torrents/' . $torrent->file_name));
		}

		$torrent->delete();

		return Redirect::route('admin_torrent_index')->with('message', 'Torrent sucessfully modified');
	}
} ?>