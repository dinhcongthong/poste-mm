<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use File;
use Validator;
use Image;
use Illuminate\Support\Facades\Log;

class ImageFactory extends Model
{
    /**
     * Instance of the Imagine package
     * @var Imagine\Gd\Imagine
     */
    protected $imagine;

    /**
     * Type of library used by the service
     * @var string
     */
    protected $library;

    /**
     * Initialize the image service
     * @return void
     */
    public function __construct() {
        // if(!$this->imagine) {
        //     $this->library = Config::get('image.library', 'gd');

        //     // Now create the instance
        //     if($this->library == 'imagick') {
        //         $this->imagine = new \Imagine\Imagick\Imagine();
        //     } elseif($this->library == 'gmagick') {
        //         $this->imagine = new \Imagine\Gmagick\Imagine();
        //     } else {
        //         $this->imagine = new \Imagine\Gd\Imagine();
        //     }
        // }
    }

    /**
	* Helper for creating thumbs
	* @param string $url
	* @param integer $width
	* @param integer $height
	* @return string
	*/
	public function thumb($url, $width, $height = null) {
		return $this->resize($url, $width, $height, true);
	}

	/**
	 * Upload an image to the public storage
	 * @param  File $file
	 * @return string
	 */
	public function upload($files = array(), $dir = '', $dimension = '', $rules = 'rules') {
        $data = array();
        $rules = Config::get('image.'.$rules);
        foreach ($files as $file) {
            if ($file) {
                $validator = Validator::make(array('file'=> $file), $rules);
                // invalid photo
                if (!$validator->passes()) {
                    return '123';
                   break;
                }

                // Generate random dir
                $dir = trim($dir, '/');
                $filename = $dir.'_'.date('Ymd').'-'.microtime(true).'.'.strtolower($file->getClientOriginalExtension());


                // Get file info and try to move
                $destination = Config::get('image.upload_path').$dir;
                $path = $dir.'/'.$filename;
                $uploaded = $file->move($destination, $filename);

                if ($uploaded) {
                    if ($dimension != "") {
                        // Get dimensions
                        $dimension_list = Config::get('image.dimensions');
                        $data[] = $this->createDimensions($path, $dimension_list[$dimension], $dimension);
                    } else {

                        $data[] = asset('upload/'.$path);
                    }
                }
            }
        }
        return $data;
    }

	/**
	 * Creates image dimensions based on a configuration
	 * @param  string $url
	 * @param  array  $dimensions
	 * @return void
	 */
	public function createDimensions($url, $dimension, $dimension_name) {
	    // Get dimmensions and quality
        $width = (int) $dimension[0];
        $height = isset($dimension[1]) ? (int) $dimension[1] : null;
        $crop = isset($dimension[2]) ? (bool) $dimension[2] : false;
        $quality = isset($dimension[3]) ? (int) $dimension[3] : Config::get('image.quality');
        // Run resizer
        $img = $this->resize($url, $width, $height, $crop, $quality, $dimension_name);

        //return original file and keep it
       /*  if ($image_return_type == '') {
            return asset('upload/'.$url);
        } */
        // delete original file
        unlink(Config::get('image.upload_path').$url);

        return $img;
    }

    /**
    * Resize an image
    * @param  string  $url
    * @param  integer $width
    * @param  integer $height
    * @param  boolean $crop
    * @param  string $dimension
    * @return string
    */
    public function resize($url, $width = 100, $height = null, $crop = false, $quality = 80, $dimension = '') {
        if ($url) {
            //URL info
            $info = pathinfo($url);

            //The size
            // if (!$height) $height = null;


            //Directories and file names
            $new_fileName = $info['filename'].'_'.$dimension.'.'.$info['extension'];
            $fileName = $info['basename'];

            $sourceDirPath = Config::get('image.upload_path').$info['dirname'];
            $sourceFilePath = $sourceDirPath . '/' . $fileName;

            $targetDirPath = $sourceDirPath . '/';
            $targetFilePath = $targetDirPath . $new_fileName;
            $targetUrl = asset('upload/'.$info['dirname'] . '/' . $new_fileName);

            //Create directory if missing
            try {
                //Create dir if missing
                if (!File::isDirectory($targetDirPath) and $targetDirPath) {
                    @File::makeDirectory($targetDirPath);
                }

                // Check Old file and New file
                if ( !File::exists($targetFilePath) or (File::lastModified($targetFilePath) < File::lastModified($sourceFilePath))) {
                    // If crop image when resize -> get center. Opposite, just resize
                    if($crop) {
                        $imgInfo = getimagesize($sourceFilePath);
                        if($imgInfo[0] > $imgInfo[1]) {
                            $imgInfo[1] = $height;
                            $imgInfo[0] = null;
                        } else {
                            $imgInfo[1] = null;
                            $imgInfo[0] = $width;
                        }


                        Image::make($sourceFilePath)->resize($imgInfo[0], $imgInfo[1], function ($constraint) {
                            $constraint->aspectRatio();
                        })->resizeCanvas($width, $height)->save($targetFilePath, $quality);
                    } else {
                        if($height) {
                            Image::make($sourceFilePath)->resize($width, $height)->save($targetFilePath, $quality);
                        } else {
                            Image::make($sourceFilePath)->resize($width, $height,  function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($targetFilePath, $quality);
                        }
                    }
                }
            }
            catch (\Exception $e) {
                return fail;
                Log::info('Resize error');
                Log::error('[IMAGE SERVICE] Failed to resize image "' . $url . '" [' . $e->getMessage() . ']');
            }

            return $targetUrl;
        }
    }
}
