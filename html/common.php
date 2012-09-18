<?php

require_once(SITE_PATH . 'functions.php');

require_once(BASE_PATH . 'classes/MongoSessionHandler.php');
MongoSessionHandler::register('codyandkate', 'sessions');
$session = MongoSessionHandler::getInstance();
require_once(BASE_PATH . 'classes/mongo.class.php');
require_once(BASE_PATH . 'classes/user.class.php');

?>
