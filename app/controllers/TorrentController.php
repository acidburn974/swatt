<?php

use Lib\Bencode;
use Lib\TorrentTools;
use Illuminate\Support\Str;

class TorrentController extends BaseController {

	/**
	 * Upload un torrent
	 *
	 */
	public function upload()
	{
		$user = Auth::user();
		if(Request::isMethod('post'))
		{
			if(Input::file('torrent')->getError() == 0 && Input::file('torrent')->getClientOriginalExtension() == 'torrent')
			{
				TorrentTools::moveAndDecode(Input::file('torrent'));
				$this->decodedTorrent = TorrentTools::$decodedTorrent;
				$this->fileName = TorrentTools::$fileName;
				$info = Bencode::bdecode_getinfo(getcwd() . '/files/torrents/' . $this->fileName, true);
				if($this->decodedTorrent['announce'] == route('announce')) // Verifie que l'url d'announce est la bonne
				{
					$input = Input::all();
					$category = Category::find(Input::get('category_id'));

					$torrent = new Torrent();
					$torrent->name = $input['name'];
					$torrent->slug = Str::slug($torrent->name);
					$torrent->description = $input['description'];
					$torrent->info_hash = $info['info_hash'];
					$torrent->file_name = $this->fileName;
					$torrent->num_file = $info['info']['filecount'];
					$torrent->announce = $this->decodedTorrent['announce'];
					$torrent->size = $info['info']['size'];
					if(Input::hasFile('nfo'))
					{
						$torrent->nfo = TorrentTools::getNfo(Input::file('nfo'));
					}
					else
					{
						$torrent->nfo = '';
					}
					//$torrent->created_by = $this->decodedTorrent['created by'];
					$torrent->category_id = $category->id;
					$torrent->user_id = $user->id;
					$torrent->leechers = 0;
					$torrent->seeders = 0;
					$torrent->times_completed = 0;

					$v = Validator::make($torrent->toArray(), $torrent->rules);
					if($v->fails())
					{
						if(file_exists(getcwd() . '/files/torrents/' . $this->fileName))
						{
							unlink(getcwd() . '/files/torrents/' . $this->fileName);
						}
						Session::put('message', 'An error has occured may ben this file is already online ?');
					}
					else
					{
						$torrent->save(); // Save le torrent
						// Compte et sauvegarde le nombre de torrent dans  cette catégorie
						$category->num_torrent = Torrent::where('category_id', '=', $category->id)->count();
						$category->save();

						// Sauvegarde les fichiers que contient le torrent
						$fileList = TorrentTools::getTorrentFiles($this->decodedTorrent);
						foreach($fileList as $file)
						{
							$f = new TorrentFile();
							$f->name = $file['name'];
							$f->size = $file['size'];
							$f->torrent_id = $torrent->id;
							$f->save();
							unset($f);
						}
						return Redirect::route('torrent', ['slug' => $torrent->slug, 'id' => $torrent->id])
						->with('message', 'Now you can download your torrent and re-seed it');
					}
				}
				else
				{
					// Delete le fichier torrent inutile car non save dans la DB
					if(file_exists(getcwd() . '/files/torrents/' . $this->fileName))
					{
						unlink(getcwd() . '/files/torrents/' . $this->fileName);
					}
					Session::put('message', 'You announce URL is invalid');
				}
			}
		}
		return View::make('torrent.upload', array('categories' => Category::all()));
	}

	/**
	* Announce code
	*
	* @access public
	* @param $passkey Passkey de l'utilisateur
	* @return Bencoded response for the torrent client
	*/
	public function announce($passkey = null)
	{
		//Log::info(Input::all());
		// Déclaration/Fetch des variables requises

		// Finding the torrent on the DB
		$torrent = Torrent::where('info_hash', '=', bin2hex(Input::get('info_hash')))->first();

		// Is torrent incorrect ?
		if($torrent == null)
		{
			return Response::make(Bencode::bencode(array('failure reason' => 'This torrent does not exist'), 200, array('Content-Type' => 'text/plain')));
		}

		// Is this a public tracker ?
		if(Config::get('other.freeleech') == true)
		{
			// Finding the current peer (client) by torrent_id and ip
			$client = Peer::whereRaw('torrent_id = ? AND ip = ?', array($torrent->id, Request::getClientIp()))->first();
		}
		else
		{
			// Finding the user in the DB
			$user = User::where('passkey', '=', $passkey)->first();

			// The user is incorrect ?
			if($user == null)
			{
				return Response::make(Bencode::bencode(array('failure reason' => 'This user does not exist'), 200, array('Content-Type' => 'text/plain')));
			}
			
			// Finding the current peer by his user_id and his torrent_id
			$client = Peer::whereRaw('user_id = ? AND torrent_id = ?', array($user->id, $torrent->id))->first();
		}

		// First time the client connect
		if($client == null)
		{
			$client = new Peer();
		}

		// Finding peers for this torrent on the database
		$peers = Peer::whereRaw('torrent_id = ?', array($torrent->id))->get()->toArray();

		// Removing useless data from the 
		foreach($peers as $k => $p)
		{
			unset($p['uploaded']); unset($p['downloaded']); unset($p['left']); unset($p['seeder']); unset($p['connectable']); unset($p['user_id']); unset($p['torrent_id']); unset($p['client']);unset($p['created_at']); unset($p['updated_at']);
			$peers[$k] = $p;
		}

		// Get the event of the tracker
		if(Input::get('event') == 'started' || Input::get('event') == null)
		{
			// Set the torrent data
			$client->peer_id = Input::get('peer_id');
			$client->ip = Request::getClientIp();
			$client->port = Input::get('port');
			$client->left = Input::get('left');
			$client->uploaded = Input::get('uploaded');
			$client->downloaded = Input::get('downloaded');
			$client->seeder = ($client->left > 0) ? false : true;
			if(Config::get('other.freeleech') == true)
			{
				$client->user_id = 0;
			}
			else
			{
				$client->user_id = $user->id;
			}
			$client->torrent_id = $torrent->id;
			$client->save();

			$torrent->seeders = Peer::whereRaw('torrent_id = ? AND `left` = 0', array($torrent->id))->count();
			$torrent->leechers = Peer::whereRaw('torrent_id = ? AND `left` > 0', array($torrent->id))->count();
			$torrent->save();
		}

		if(Input::get('event') == 'completed')
		{
			if($client == null && $client->left > 0)
			{
				return Response::make(Bencode::bencode(array('failure reason' => 'Are you fucking kidding me ?'), 200, array('Content-Type' => 'text/plain')));
			}
			$torrent->times_completed++;
			$torrent->save();
			$client->left = 0;
			$client->seeder = 0;
			$client->save();
		}

		if(Input::get('event') == 'stopped')
		{
			if($client != null)
			{
				$client->delete();
			}
			else
			{
				return Response::make(Bencode::bencode(array('failure reason' => 'You don\'t have a life'), 200, array('Content-Type' => 'text/plain')));
			}
		}

		$resp['complete'] = $torrent->seeders;
		$resp['incomplete'] = $torrent->leechers;
		$resp['peers'] = $peers;

		return Response::make(Bencode::bencode($resp), 200, array('Content-Type' => 'text/plain'));
	}

	/**
	 * Affiche la liste des torrents
	 *
	 * @access public
	 * @return page.torrents
	 */
	public function torrents()
	{
		$torrents = Torrent::orderBy('created_at', 'DESC')->paginate(20);
		return View::make('page.torrents', array('torrents' => $torrents));
	}

	/**
	 * Affiche le torrent désiré
	 *
	 * @access public
	 * @param $slug Slug du torrent
	 * @param $id Id du torrent
	 *
	 */
	public function torrent($slug, $id)
	{
		$torrent = Torrent::find($id);
		$user = $torrent->user;
		$comments = $torrent->comments()->orderBy('created_at', 'DESC')->get();
		return View::make('torrent.torrent', array('torrent' => $torrent, 'comments' => $comments, 'user' => $user));
	}

	/**
	 * Telecharge le torrent
	 *
	 */
	public function download($slug, $id)
	{
		if(Auth::check())
		{
			$user = Auth::user();
			// User's ratio is too low
			if($user->getDownloaded() / $user->getUploaded() < Config::get('other.ratio') && Config::get('other.freeleech') == false)
			{
				return Redirect::route('torrent', ['slug' => $torrent->slug, 'id' => $torrent->id])->with('message', 'You can\'t download torrents anymore your ratio is too low');
			}
		}
		else
		{
			$user = null;
		}
		
		// Find th etorrent in the
		$torrent = Torrent::find($id);

		// Define the filename for the download
		$tmpFileName = $torrent->slug . '.torrent';

		// The torrent file exist ?
		if( ! file_exists(getcwd() . '/files/torrents/' . $torrent->file_name))
		{
			return Redirect::route('torrent', array('slug' => $torrent->slug, 'id' => $torrent->id))
			->with('message', 'The torrent file is currently unavailable');
		}
		else
		{
			// Delete the last torrent tpm file
			if(file_exists(getcwd() . '/files/tmp/' . $tmpFileName))
			{
				unlink(getcwd() . '/files/tmp/' . $tmpFileName);
			}
		}
		// Get the content of the torrent
		$dict = Bencode::bdecode(file_get_contents(getcwd() . '/files/torrents/' . $torrent->file_name));
		// Freeleech ?
		if(Config::get('other.freeleech') == true)
		{
			// Set the announce key only
			$dict['announce'] = route('announce');
		}
		else
		{
			if(Auth::check())
			{
				// Set the announce key and add the user passkey
				$dict['announce'] = route('announce', array('passkey' => $user->passkey));
				// Remove Other announce url
				unset($dict['announce-list']);
			}
			else
			{
				return Redirect::to('/login');
			}
		}
		
		$fileToDownload = Bencode::bencode($dict);
		file_put_contents(getcwd() . '/files/tmp/' . $tmpFileName, $fileToDownload);
		return Response::download(getcwd() . '/files/tmp/' . $tmpFileName);
	}

	public function api_torrent($id)
	{
		// Find the right torrent
		$torrent = Torrent::find($id);
		// Format the description
		$torrent->descriptionHtml = $torrent->getDescriptionHtml();
		// Set username
		$torrent->username = $torrent->user->username;
		// Set user id
		$torrent->user_id = $torrent->user->id;
		// Define the size
		$torrent->size = $torrent->getSize();

		return Response::json($torrent);
	}
} ?>
