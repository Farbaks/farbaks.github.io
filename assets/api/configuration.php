<?php 

function connecttodatabase() {

	$connection = array(
		'server' => 'localhost',
		'username' => 'root',
		'password' => '',
		'dbname' => 'flights'
	);
		
	$db = mysqli_connect(
	$connection['server'], $connection['username'], $connection['password'], $connection['dbname']);

	if (!$db) {
		die("Connection failed: ".mysql_error());
	}

	return $db;
}

?>