<?php
return array(
    'library' => 'gd',
    'upload_path' => public_path() . '/upload/',
    'quality' => 100,
    'rules'	=> array(
    	'file' => 'required|mimes:png,gif,jpeg,svg,jpg,bmp|max:6150', //~6MB
    ),
 
    'dimensions' => array(
        'icon' => array(100, 100, false, 100),
        'thumb' => array(300, 300, true, 100),
        'medium' => array(960, null, false, 100),
        'large' => array(1200, null, false, 100),
    ),
);