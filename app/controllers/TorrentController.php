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
					$torrent = new Torrent();
					$torrent->name = $input['name'];
					$torrent->slug = Str::slug($torrent->name);
					$torrent->description = $input['description'];
					$torrent->info_hash = $info['info_hash'];
					$torrent->file_name = $this->fileName;
					$torrent->file_count = $info['info']['filecount'];
					$torrent->announce = $this->decodedTorrent['announce'];
					$torrent->size = $info['info']['size'];
					if(Input::hasFile('nfo'))
						$torrent->nfo = TorrentTools::getNfo(Input::file('nfo'));
					else
						$torrent->nfo = '';
					$torrent->created_by = $this->decodedTorrent['created by'];
					$torrent->category_id = $input['category_id'];
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
						Session::put('message', 'An error has occured');
					}
					else
					{
						$torrent->save();
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
	* ANNOUNCE
	*
	*/
	public function announce($passkey)
	{
		Log::info(Input::all());
		// Déclaration/Fetch des variables requises
		$user = User::where('passkey', '=', $passkey)->first();
		if($user == null)
		{
			return Response::make(Bencode::bencode(array('failure reason' => 'This user does not exist'), 200, array('Content-Type' => 'text/plain')));
		}
		$torrent = Torrent::where('info_hash', '=', bin2hex(Input::get('info_hash')))->first();
		if($torrent == null)
		{
			return Response::make(Bencode::bencode(array('failure reason' => 'This torrent does not exist'), 200, array('Content-Type' => 'text/plain')));
		}
		$client = Peer::whereRaw('user_id = ? AND torrent_id = ?', array($user->id, $torrent->id))->first();
		if($client == null)
		{
			$client = new Peer();
		}
		else
		{
			$user->uploaded += Input::get('uploaded') - $client->uploaded;
			$user->downloaded += Input::get('downloaded') - $client->downloaded;
			$user->save();
		}
		$peers = Peer::whereRaw('torrent_id = ?', array($torrent->id))->get()->toArray();
		foreach($peers as $k => $p)
		{
			unset($p['uploaded']); unset($p['downloaded']); unset($p['left']); unset($p['seeder']); unset($p['connectable']); unset($p['user_id']); unset($p['torrent_id']); unset($p['client']);unset($p['created_at']); unset($p['updated_at']);
			$peers[$k] = $p;
		}

		if(Input::get('event') == 'started' || Input::get('event') == null)
		{
			$client->peer_id = Input::get('peer_id');
			$client->ip = Request::getClientIp();
			$client->port = Input::get('port');
			$client->left = Input::get('left');
			$client->uploaded = Input::get('uploaded');
			$client->downloaded = Input::get('downloaded');
			$client->seeder = ($client->left > 0) ? false : true;
			$client->user_id = $user->id;
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
		//Log::info($resp);
		return Response::make(Bencode::bencode($resp), 200, array('Content-Type' => 'text/plain'));
	}

	/**
	 * Affiche la liste des torrents
	 *
	 */
	public function torrents()
	{
		$torrents = Torrent::orderBy('created_at', 'DESC')->paginate(20);
		return View::make('page.torrents', array('torrents' => $torrents));
	}

	/**
	 * Affiche le torrent désiré
	 *
	 *
	 */
	public function torrent($slug, $id)
	{
		$torrent = Torrent::find($id);
		return View::make('torrent.torrent', array('torrent' => $torrent));
	}

	/**
	 * Telecharge le torrent
	 *
	 */
	public function download($slug, $id)
	{
		$user = Auth::user();
		$torrent = Torrent::find($id);
		$dict = Bencode::bdecode(file_get_contents(getcwd() . '/files/torrents/' . $torrent->file_name));
		$dict['announce'] = route('announce', array('passkey' => $user->passkey));
		unset($dict['announce-list']);
		$fileToDownload = Bencode::bencode($dict);
		$tmpFileName = $torrent->slug . '.torrent';
		file_put_contents(getcwd() . '/files/tmp/' . $tmpFileName, $fileToDownload);
		return Response::download(getcwd() . '/files/tmp/' . $tmpFileName);
	}
}

?>
