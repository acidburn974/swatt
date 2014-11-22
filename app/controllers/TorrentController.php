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
		//Log::info(Input::all());

		// Correct info hash
		$infoHash = bin2hex((Input::get('info_hash') != null) ? Input::get('info_hash') : Input::get('hash_id'));

		// Finding the torrent on the DB
		$torrent = Torrent::where('info_hash', '=', $infoHash)->first();

		// Is torrent incorrect ?
		if($torrent == null)
		{
			return Response::make(Bencode::bencode(array('failure reason' => 'This torrent does not exist'), 200, array('Content-Type' => 'text/plain')));
		}

		// Is this a public tracker ?
		if(Config::get('other.freeleech') == false)
		{
			// Finding the user in the DB
			$user = User::where('passkey', '=', $passkey)->first();

			// The user is incorrect ?
			if($user == null)
			{
				return Response::make(Bencode::bencode(array('failure reason' => 'This user does not exist'), 200, array('Content-Type' => 'text/plain')));
			}
		}
		// Finding the correct client/peer by the md5 of the peer_id
		$client = Peer::whereRaw('md5_peer_id = ?', [md5(Input::get('peer_id'))])->first();

		// First time the client connect
		if($client == null)
		{
			$client = new Peer();
		}

		// Deleting old peers from the database
		foreach(Peer::all() as $peer)
		{
			if((time() - strtotime($peer->updated_at)) > (50 * 60))
			{
				$peer->delete();
			}
		}

		// Finding peers for this torrent on the database
		$peers = Peer::whereRaw('torrent_id = ?', array($torrent->id))->take(50)->get()->toArray();

		// Removing useless data from the
		foreach($peers as $k => $p)
		{
			unset($p['uploaded']); unset($p['downloaded']); unset($p['left']); unset($p['seeder']); unset($p['connectable']); unset($p['user_id']); unset($p['torrent_id']); unset($p['client']);unset($p['created_at']); unset($p['updated_at']);
			unset($p['md5_peer_id']);
			$peers[$k] = $p;
		}


		// Get the event of the tracker
		if(Input::get('event') == 'started' || Input::get('event') == null)
		{
			// Set the torrent data
			$client->peer_id = Input::get('peer_id');
			$client->md5_peer_id = md5($client->peer_id);
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

		// Savegarde le ratio de l'utilisateur
		if(Config::get('other.freeleech') == false)
		{
			// Modification de l'upload/download de l'utilisateur pour le ratio
			$user->uploaded += Input::get('uploaded') - $client->uploaded;
			$user->downloaded += Input::get('downloaded') - $client->downloaded;
			$user->save();
		}

		$resp['interval'] = 600; // Set to 60 for debug
		$resp['min interval'] = 300; // Set to 30 for debug
		$resp['tracker_id'] = $client->md5_peer_id; // A string that the client should send back on its next announcements.
		$resp['complete'] = $torrent->seeders;
		$resp['incomplete'] = $torrent->leechers;
		$resp['peers'] = $peers;

		//Log::info($resp);

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
		if(Auth::check())
		{
			// Current user is the logged in user
			$user = Auth::user();
			// Find the torrent in the database
			$torrent = Torrent::find($id);
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
		if( ! file_exists(getcwd() . '/files/torrents/' . $torrent->file_name))
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
