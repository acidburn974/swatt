<?php

namespace Lib;

/**
 * Bencode library for torrents
 *
 */
class Bencode
{
	public static function bdecode($s, & $pos = 0)
	{
		if ($pos >= strlen($s)){
			return NULL;
		}

		switch ($s[$pos]) {
			case 'd':
				$pos ++;
				$retval = array();
				while ($s[$pos] != 'e'){
					$key = self::bdecode($s, $pos);
					$val = self::bdecode($s, $pos);
					if ($key === NULL || $val === NULL){
						break;
					}
					$retval[$key] = $val;
				}
				$retval['isDct'] = TRUE;
				$pos ++;
				return $retval;

			case 'l':
				$pos ++;
				$retval = array();
				while ($s[$pos] != 'e'){
					$val = self::bdecode($s, $pos);
					if ($val === NULL){
						break;
					}
					$retval[] = $val;
				}
				$pos ++;
				return $retval;

			case 'i':
				$pos ++;
				$digits = strpos($s, 'e', $pos) - $pos;
				$val    = round( (float) substr($s, $pos, $digits));
				$pos += $digits + 1;
				return $val;

			default:
				$digits = strpos($s, ':', $pos) - $pos;
				if ($digits < 0 || $digits > 20){
					return NULL;
				}
				$len = (int) substr($s, $pos, $digits);
				$pos += $digits + 1;
				$str = substr($s, $pos, $len);
				$pos += $len;
				return (string) $str;
		}
    }

    public static function bencode($d)
    {
        if (is_array($d)){
            $ret='l';
            $is_dict = false;
            if(!isset($d['isDct'])){
                foreach (array_keys($d) as $key) {
                    if (!is_int($key)) {
                        $is_dict = true;
                        break;
                    }
                }
            }else{
                $is_dict = (bool) $d['isDct'];
                unset($d['isDct']);
            }

            if($is_dict){
                $ret='d';
                // this is required by the specs, and BitTornado actualy chokes on unsorted dictionaries
                ksort($d, SORT_STRING);
            }

            foreach ($d as $key=>$value) {
                if ($is_dict)
                {
                    $ret .= strlen($key).':'.$key;
                }

                if (is_int($value) || is_float($value))
                {
                    $ret .= sprintf('i%de',$value);
                }
                elseif (is_string($value))
                {
                    $ret .= strlen($value).':'.$value;
                }
                else
                {
                    $ret .= self::bencode ($value);
                }
            }
            return $ret.'e';
        }
        elseif (is_string($d))
        {
            return strlen($d).':'.$d;
        }
        elseif (is_int($d) || is_float($d))
        {
            return sprintf('i%de',$d);
        }
        else
        {
            return NULL;
        }
    }

    public static function bdecode_file($filename)
    {
        $f=file_get_contents($filename, FILE_BINARY);
        return self::bdecode($f);
    }

    public static function bdecode_getinfo($filename,$need_info_hash = FALSE)
    {
        $t = self::bdecode_file($filename);
        $t['info_hash'] = $need_info_hash ? sha1(self::bencode($t['info'])) : NULL;

        if (isset($t['info']['files']) && is_array($t['info']['files'])) //multifile
        {
            $t['info']['size'] = 0;
            $t['info']['filecount'] = 0;

            foreach ($t['info']['files'] as $file)
            {
                $t['info']['filecount']++;
                $t['info']['size']+=$file['length'];
            }
        }
        else
        {
            $t['info']['size'] = $t['info']['length'];
            $t['info']['filecount'] = 1;
            $t['info']['files'][0]['path'] = $t['info']['name'];
            $t['info']['files'][0]['length'] = $t['info']['length'];
        }
        return $t;
    }
}


?>
