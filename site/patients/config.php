<?php
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'gpo');
define('DB_SERVER_PASSWORD', 'gpo2012*/');
define('DB_DATABASE', 'gpo');

$connexion = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
?>