<?php

use Lib\Bencode;
use Lib\TorrentTools;
use Illuminate\Support\Str;

/**
 * Gestion des torrents
 *
 *
 */
class TorrentController extends BaseController {

	/**
	 * Upload un torrent
	 * 
	 * @access public
	 * @return View torrent.upload
	 *
	 */
	public function upload()
	{
		$user = Auth::user();
		// Post et fichier upload
		if(Request::isMethod('post'))
		{
			// No torrent file uploaded OR an Error has occurred
			if(Input::hasFile('torrent') == false)
			{
				Session::put('message', 'You must provide a torrent for the upload');
				return View::make('torrent.upload', array('categories' => Category::all(), 'user' => $user));
			}
			else if(Input::file('torrent')->getError() != 0 && Input::file('torrent')->getClientOriginalExtension() != 'torrent')
			{
				
				Session::put('message', 'An error has occurred');
				return View::make('torrent.upload', array('categories' => Category::all(), 'user' => $user));
			}
			// Deplace et decode le torrent temporairement
			TorrentTools::moveAndDecode(Input::file('torrent'));
			// Array from decoded from torrent
			$decodedTorrent = TorrentTools::$decodedTorrent;
			// Tmp filename
            $fileName = TorrentTools::$fileName;
            // Info sur le torrent
            $info = Bencode::bdecode_getinfo(getcwd() . '/files/torrents/' . $fileName, true);

            // Si l'announce est invalide ou si le tracker et privée
            if($decodedTorrent['announce'] != route('announce', ['passkey' => $user->passkey]) && Config::get('other.freeleech') == true)
            {
            	Session::put('message', 'Your announce URL is invalid');
				return View::make('torrent.upload', array('categories' => Category::all(), 'user' => $user));
            }

            // Find the right category
            $category = Category::find(Input::get('category_id'));
            // Create the torrent (DB)
            $torrent = new Torrent([
            	'name' => Input::get('name'),
            	'slug' => Str::slug(Input::get('name')),
            	'description' => Input::get('description'),
            	'info_hash' => $info['info_hash'],
            	'file_name' => $fileName,
            	'num_file' => $info['info']['filecount'],
            	'announce' => $decodedTorrent['announce'],
            	'size' => $info['info']['size'],
            	'nfo' => (Input::hasFile('nfo')) ? TorrentTools::getNfo(Input::file('nfo')) : '',
            	'category_id' => $category->id,
            	'user_id' => $user->id,
            ]);
            // Validation
            $v = Validator::make($torrent->toArray(), $torrent->rules);
            if($v->fails())
            {
            	if(file_exists(getcwd() . '/files/torrents/' . $fileName))
            	{
            		unlink(getcwd() . '/files/torrents/' . $fileName);
            	}
            	Session::put('message', 'An error has occured may bee this file is already online ?');
            }
            else
            {
            	// Savegarde le torrent
            	$torrent->save(); 
            	// Compte et sauvegarde le nombre de torrent dans  cette catégorie
                $category->num_torrent = Torrent::where('category_id', '=', $category->id)->count();
                $category->save();

                // Sauvegarde les fichiers que contient le torrent
                $fileList = TorrentTools::getTorrentFiles($decodedTorrent);
                foreach($fileList as $file)
                {
                    $f = new TorrentFile();
                    $f->name = $file['name'];
                    $f->size = $file['size'];
                    $f->torrent_id = $torrent->id;
                    $f->save();
                    unset($f);
                }
                return Redirect::route('torrent', ['slug' => $torrent->slug, 'id' => $torrent->id])->with('message', trans('torrent.your_torrent_is_now_seeding'));
            }
		}
		return View::make('torrent.upload', array('categories' => Category::all(), 'user' => $user));
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
		// Pas de passkey et pas de freeleech
		if(Config::get('other.freeleech') == false && $passkey == null)
		{
			return Response::make(Bencode::bencode(array('failure reason' => 'Passkey is invalid')), 200, array('Content-Type' => 'text/plain'));
		}

		$hash = bin2hex(Input::get('info_hash')); // Get hash

		if( !Config::get('other.freelech'))
		{
			$torrent = Torrent::where('info_hash', '=', $hash)->first();
			if(is_null($torrent))
			{
				return Response::make(Bencode::bencode(array('failure reason' => 'Torrent not found')), 200, array('Content-Type' => 'text/plain'));
			}
		}
		else
		{
			$torrent = null;
		}

		$user = (Config::get('other.freelech') == false) ? User::where('passkey', '=', $passkey)->first() : null; // Get the user

		$client = Peer::where('md5_peer_id', '=', md5(Input::get('peer_id')))->first(); // Get the current peer

		if($client == null) { $client = new Peer(); } // Crée un nouveau client si non existant

		Peer::deleteOldPeers(); // Delete olds peers from database

		$peers = Peer::where('hash', '=', $hash)->take(50)->get()->toArray(); // Liste des pairs

		$seeders = 0;
		$leechers = 0;

		foreach($peers as &$p)
		{
			if($p['left'] > 0)
				$leechers++; // Compte le nombre de leechers
			else
				$seeders++; // Compte le nombre de seeders

			unset($p['uploaded'], $p['downloaded'], $p['left'], $p['seeder'], $p['connectable'], $p['user_id'], $p['torrent_id'], $p['client'], $p['created_at'], $p['updated_at'], $p['md5_peer_id']);
		}

		// Get the event of the tracker
		if(Input::get('event') == 'started' || Input::get('event') == null)
		{
			// Set the torrent data
			$client->peer_id = Input::get('peer_id');
			$client->md5_peer_id = md5($client->peer_id);
			$client->hash = $hash;
			$client->ip = Request::getClientIp();
			$client->port = Input::get('port');
			$client->left = Input::get('left');
			$client->uploaded = Input::get('uploaded');
			$client->downloaded = Input::get('downloaded');
			$client->seeder = ($client->left == 0) ? true : false;
			$client->user_id = (Config::get('other.freeleech') == false) ? $user->id : null;
			$client->torrent_id = (Config::get('other.freeleech') == false) ? $torrent->id : null;
			$client->save();
		}
		elseif(Input::get('event') == 'completed')
		{
			if(Config::get('other.freeleech') == false)
			{
				$torrent->times_completed++;
				$torrent->save();
			}
			$client->left = 0;
			$client->seeder = true;
			$client->save();
		}
		elseif(Input::get('event') == 'stopped')
		{
			$client->delete();
		}
		else { }

		if(Config::get('other.freeleech') == false && $torrent != null && $user != null)
		{
			$torrent->seeders = Peer::whereRaw('torrent_id = ? AND `left` = 0', array($torrent->id))->count();
			$torrent->leechers = Peer::whereRaw('torrent_id = ? AND `left` > 0', array($torrent->id))->count();
			$torrent->save();

			// Modification de l'upload/download de l'utilisateur pour le ratio
			$user->uploaded += Input::get('uploaded') - $client->uploaded;
			$user->downloaded += Input::get('downloaded') - $client->downloaded;
			$user->save();
		}
		
		$res['interval'] = 60; // Set to 60 for debug
		$res['min interval'] = 30; // Set to 30 for debug
		$res['tracker_id'] = $client->md5_peer_id; // A string that the client should send back on its next announcements.
		$res['complete'] = $seeders;
		$res['incomplete'] = $leechers;
		$res['peers'] = $peers;

		return Response::make(Bencode::bencode($res), 200, array('Content-Type' => 'text/plain'));
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
		return View::make('torrent.torrents', array('torrents' => $torrents));
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
	 * @access public
	 * @param string $slug Slug du torrent
	 * @param int $id Id du torrent 
	 * @return file
	 */
	public function download($slug, $id)
	{
		// Find the torrent in the database
		$torrent = Torrent::find($id);

		if(Auth::check())
		{
			// Current user is the logged in user
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

		// Define the filename for the download
		$tmpFileName = $torrent->slug . '.torrent';

		// The torrent file exist ?
		if( !file_exists(getcwd() . '/files/torrents/' . $torrent->file_name))
		{
			return Redirect::route('torrent', array('slug' => $torrent->slug, 'id' => $torrent->id))
			->with('message', 'The torrent file is currently unavailable');
		}
		else
		{
			// Delete the last torrent tmp file
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
} ?>
