<?php
	$mysqli = new mysqli('127.0.0.1','gpo','gpo2012*/','gpo');
	$acentos = $mysqli->query("SET NAMES 'utf8'");
	if ($mysqli->connect_error)
	{
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}
?>