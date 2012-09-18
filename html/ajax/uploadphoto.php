<?php

require_once('../config.php');

header('Vary: Accept');
if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
		header('Content-type: application/json');
	} else {
		header('Content-type: text/plain');
}

try {
	$m = new Mongo();
	$db = $m->codyandkate;
} catch (MongoException $e) {
	$error[] = $e->getMessage();
	echo json_encode($error);
	exit(0);
}

if($_FILES) {

	foreach($_FILES as $file) {

		$photo	= array(
			'name' => $file['name'][0],
			'size' => $file['size'][0],
			'type' => $file['type'][0],
			'comments' => array());
		$db->photos->insert($photo);

		$photo_id = get_object_vars($photo['_id']);
		$id = $photo_id['$id'];

		if($file['type'][0] == 'image/jpeg') {
			move_uploaded_file($file['tmp_name'][0], UPLOAD_PATH . 'full/' . $id . '.jpg');
			sqThm(UPLOAD_PATH . 'full/' . $id . '.jpg', UPLOAD_PATH . 'thumb/' . $id . '.jpg');
			$response = array(array(
				'name' => $photo['name'],
				'size' => $photo['size'],
				'url' => '//codyandkate.com/uploads/full/' . $id . '.jpg',
				'thumbnail_url' => '//codyandkate.com/uploads/thumb/' . $id . '.jpg',
				'delete_url' => '//wow/deleete.php?id=' . $id,
				'delete_type' => 'DELETE'));
		}
	}

	echo json_encode($response);

}



?>
