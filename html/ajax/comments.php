<?php

require_once('../classes/db.class.php');
$db = new DataBase();
if(!isset($_POST['id']) || !isset($_POST['action'])) {

	exit('Proper arguments not supplied. Try again, or tell Cody if it keeps happening.');

} else {

	$id = substr($_POST['id'], 5);

	switch($_POST['action']) {

		case 'GetComments':

			$qs = "SELECT * FROM comments WHERE photo_id = '".$id."' ORDER BY comment_id ASC";
			$results = $db->select($qs);

			echo json_encode($results);
		break;

	}

}



?>
