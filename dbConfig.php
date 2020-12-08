<?php

	//database configuration
	$dbHost = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "movingworlds";

	//create dabase connection
	try {
		$db = new PDO("mysql:host=$dbHost;dbname=$dbName",$dbUsername,$dbPassword);

	} catch (PDOException $e) {
		echo "Connection failed : ". $e->getMessage();
	}

?>