<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use URL;
use Config;
use File;

class Base extends Model
{
	/**
	* Get uploaded Image URL from Filename, directory, size (900x600, 900x450, 300x300)
	*
	* @param string $filename: Name of image.
	* @param string $dir: Directory of image.
	* @param string size: specific size of image. (value: '', 900x600, 900x450, 300x300)
	* @param boolean getOriginalIfFail: If image don't exists specific
	*
	* @return string: url of image.
	*/
	public static function getUploadURL($filename, $dir = '/', $size = '', $getOriginalIfFail = true) {
		if (strlen($filename) > 0) {
			$dir = trim($dir, '/');
			$filename = trim($filename, '/');

			if($size == '900x600') {
				$size = '600x400';
			}
			$prefix = 'http://';
			$prefix_ssl = 'https://';
			if (substr_compare($filename, $prefix, 0, 7) != 0 && substr_compare($filename, $prefix_ssl, 0, 8) != 0) {
				if(!empty($size)) {
					$originalNameArray = explode('/', $filename);
					$originalName = end($originalNameArray);
					$names = explode('.', $originalName);
					if(count($names) > 1) {
						array_pop($names);
					}
					$name = implode('.', $names);
					$path = Config::get('image.upload_path');
					if(count($originalNameArray) > 1) {
						array_pop($originalNameArray);
					}
					$dir1 = $dir.'/'.implode('/', $originalNameArray);
					$dir1 = trim($dir1, '/');
					if(!empty($dir1) && $dir1 != '/') {
						$pathFile = $path.$dir1.'/'.$size.'_'.$name.'.jpg';
						if(File::exists($pathFile)) {
							return URL::to('upload').'/'.$dir1.'/'.$size.'_'.$name.'.jpg';
						} else {
							if($getOriginalIfFail) {
								return !empty($dir) && $dir != '/' ? URL::to('upload').'/'.$dir.'/'.$filename : URL::to('upload').'/'.$filename;
							} else {
								return null;
							}
						}
					} else {
						$pathFile = $path.$size.'_'.$name.'.jpg';

						if(File::exists($pathFile)) {
							return !empty($dir) && $dir != '/' ? URL::to('upload').'/'.$dir.'/'.$filename : URL::to('upload').'/'.$filename;
						} else {
							if($getOriginalIfFail) {
								return URL::to('upload').$dir.$filename;
							} else {
								return null;
							}
						}
					}
				} else {
					return !empty($dir) && $dir != '/' ? URL::to('upload').'/'.$dir.'/'.$filename : URL::to('upload').'/'.$filename;
				}
			}
		}
		return $filename;
	}

	public static function getUploadFilename($url) {
		if (strlen($url) > 0) {
			$pattern = '/http[s]*:\/\/[\/a-zA-Z0-9:_\-.]*poste[\/a-zA-Z0-9:_\-.]*upload\/[0-9a-zA-Z_.\/-]+\.[a-zA-Z]+/i';


			if(preg_match($pattern, $url, $matches)) {
				foreach($matches as $key => $match) {
					$str = explode('/', $match);

					$dir = $str[count($str) - 2];
					$filename = end($str);

					if ($dir == 'upload') {
						return array(
							'dir' => '',
							'filename' => $filename
						);
					}

					return array(
						'dir' => $dir,
						'filename' => $filename
					);
				}
			}
		}

		return array(
			'dir' => '',
			'filename' => $url
		);
	}
}
