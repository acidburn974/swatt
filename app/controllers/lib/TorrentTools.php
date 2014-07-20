<?php

namespace Lib;

class TorrentTools {

	/**
	 * Nom du fichier qui sera sauvegarder
	 *
	 */
	public static $fileName = '';

	/**
	 * Tableau représentatif du torrent décodé
	 *
	 */
	public static $decodedTorrent = array();

	/**
	 * Déplace et décode le torrent
	 *
	 * @access private
	 */
	public static function moveAndDecode($torrentFile)
	{
		self::$fileName = uniqid() . '.torrent'; // Genere un nom unique
		$torrentFile->move(getcwd() . '/files/torrents/', self::$fileName); // Déplace
		self::$decodedTorrent = Bencode::bdecode_file(getcwd() . '/files/torrents/' . self::$fileName);
	}

	/**
	 * Calcul le nombre de fichier présent dans le torrent
	 *
	 */
	public static function getFileCount($decodedTorrent)
	{
		// Torrent à fichier multiple
		if(array_key_exists("files", $decodedTorrent['info']) && count($decodedTorrent['info']['files'])) {
			return count($decodedTorrent['info']['files']);
		}
		return 1;
	}

	/**
	 * Retourne la taille des fichiers du torrent
	 *
	 */
	public static function getTorrentSize($decodedTorrent)
	{
		$size = 0;
		if(array_key_exists("files", $decodedTorrent['info']) && count($decodedTorrent['info']['files'])) // Torrent à fichiers multiple
		{
			foreach ($decodedTorrent['info']['files'] as $k => $file)
			{
				$dir = '';
				$size += $file['length'];
				$count = count($file["path"]);
			}
		}
		else
		{
			$size = $decodedTorrent['info']['length'];
			//$files[0] = $decodedTorrent['info']['name.utf-8'];
		}
		return $size;
	}

	/**
	 * Retourne la liste des fichiers du torrent
	 *
	 *
	 */
	public static function getTorrentFiles($decodedTorrent)
	{
		if(array_key_exists("files", $decodedTorrent['info']) && count($decodedTorrent['info']['files'])) // Torrent à fichiers multiple
		{
			foreach ($decodedTorrent['info']['files'] as $k => $file)
			{
				$dir = '';
				$count = count($file["path"]);
				for ($i = 0; $i < $count; $i++)
				{
					if (($i + 1) == $count)
					{
						$fname = $dir.$file["path"][$i];
						$files[$k]['name'] = $fname;
					}
					else
					{
						$dir .= $file["path"][$i]."/";
						$files[$k]['name'] = $dir;
					}
					$files[$k]['size'] = $file['length'];
				}
			}
		}
		else
		{
			$files[0]['name'] = $decodedTorrent['info']['name'];
			$files[0]['size'] = $decodedTorrent['info']['length'];
		}
		return $files;
	}

	/**
	 * Retourne le sha1 (hash) du torrent
	 *
	 */
	public static function getTorrentHash($decodedTorrent)
	{
		return sha1(Bencode::bencode($decodedTorrent['info']));
	}

	/**
	 * Retourne le nombre de fichier du torrent
	 *
	 */
	public static function getTorrentFileCount($decodedTorrent)
	{
		if(array_key_exists("files", $decodedTorrent['info']))
		{
			return count($decodedTorrent['info']['files']); // Torrent à fichiers multiple
		}
		return 1; // Torrent à fichier unique
	}

	/**
	 * Retourne le contenue du NFO
	 *
	 */
	public static function getNfo($inputFile)
	{
		try
		{
			$fileName = uniqid() . '.nfo';
			$inputFile->move(getcwd() . '/files/tmp/', $fileName);
		}
		catch(Exception $e)
		{

		}
		if(file_exists(getcwd() . '/files/tmp/' . $fileName))
		{
			$fileContent = file_get_contents(getcwd() . '/files/tmp/' . $fileName);
			unlink(getcwd() . '/files/tmp/' . $fileName);
		}
		else
		{
			$fileContent = null;
		}
		return $fileContent;
	}
} ?>
