<?php
session_start();
require_once('../config.php');

echo '$_SESSION = '; print_r($_SESSION); echo '<br />';
// echo '$SESSION USER ID '.$session->get_id();


echo "<br />";

print_r($session);
// echo $session->data['user_id'];
// $sql = "SELECT * FROM `users` WHERE `user_first_name` = ? AND `user_last_name` = ?";
// $values = array('Cody','Halovich');
echo "<br/>";





?>
