<?php

class Flickr { 

	var $flickr = array(
			'key' 		=> 'f7f5c944d6b6a2aa189de3cc0d1a0a6b',
			'secret' 	=> '77f36f80e5fc5569'
	);

	public function GetPhotosByTag($tags) {

		$params = array(
			'api_key'	=> $this->flickr['key'],
			'method' 	=> 'flickr.photos.search',
			'tags' 		=> $tags,
			'format'	=> 'php_serial',
			'user_id'	=> '63619133@N07'
		);

		$encoded_params = array();
		foreach($params as $k => $v) {
			$encoded_params[] = urlencode($k).'='.urlencode($v);
		}

		$url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);

		$response = file_get_contents($url);
		$rsp_obj = unserialize($response);

		$photos = array();
		foreach($rsp_obj['photos']['photo'] as $photo) {
			$photos[] = $photo;
		}

		return $photos;

	}

}

$photos = new Flickr();
?>
