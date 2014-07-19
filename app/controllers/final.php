		//Log::info(Input::all());
		$info_hash = bin2hex(Input::get('info_hash'));
		$ip = Request::getClientIp();
		$user = User::where('passkey', '=', Input::get('passkey'))->first();
		$resp = array();
		if($user == null)
		{
			return Response::make(Bencode::bencode(array('failure reason' => 'Utilisateur inexistant'), 200, array('Content-Type' => 'text/plain')));
		}
		$torrent = Torrent::where('info_hash', '=', bin2hex(Input::get('info_hash')))->first();
		if($torrent == null)
		{
			return Response::make(Bencode::bencode(array('failure reason' => 'Torrent inexistant'), 200, array('Content-Type' => 'text/plain')));
		}
		if(Input::get('compact') == 1)
		{
			$resp['interval'] = 300;
		}
		else
		{
			$resp['interval'] = 600;
			$resp['min interval'] = 300;
		}
		$peers = Peer::whereRaw('torrent_id = ?', array($torrent->id))->get()->toArray(); // Liste des clients sur le torrent
		$curPeer = Peer::whereRaw('torrent_id = ? AND user_id = ?', array($torrent->id, $user->id))->first(); // Le client actuel
		//Log::info($peers);
		if($curPeer == null && Input::get('event') == 'started')
		{
			$curPeer = new Peer();
			$curPeer->peer_id = Input::get('peer_id');
			$curPeer->ip = $ip;
			$curPeer->port = Input::get('port');
			$curPeer->uploaded = Input::get('uploaded');
			$curPeer->downloaded = Input::get('downloaded');
			$curPeer->left = Input::get('left');
			/*if($curPeer->left == 0)
			{
				$curPeer->seeder = true;
			}
			else
			{
				$curPeer->seeder = false;
			}*/
			$sockres = @fsockopen($ip, Input::get('port'), $errno, $errstr, 5);
			if($sockres)
			{
				$curPeer->connectable = true;
			}
			else
			{
				$curPeer->connectable = false;
			}
			@fclose($sockres);
			$curPeer->user_id = $user->id;
			$curPeer->torrent_id = $torrent->id;
			$curPeer->save();
		}
		$resp['complete'] = $torrent->seeders;
		$resp['incomplete'] = $torrent->leechers;
		$resp['peers'] = $peers;
		if(Input::get('event') == 'stopped')
		{
			$curPeer->delete();
		}
		if(Input::get('event') == 'completed')
		{
			$torrent->times_completed++;
			$torrent->seeders++;
			$torrent->leechers--;
			$torrent->save();
			$curPeer->seeder = true;
			$curPeer->save();
		}
		//Log::info($resp);
		return Response::make(Bencode::bencode($resp), 200, array('Content-Type' => 'text/plain'));		