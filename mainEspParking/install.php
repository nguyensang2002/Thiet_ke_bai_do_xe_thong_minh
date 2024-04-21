<?php
//Create Data base if not exists
	$servername = "localhost";
	$username = "root";
	$password = "";

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// Create database
	$sql = "CREATE DATABASE mainEspParking";
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully";
	} else {
	    echo "Error creating database: " . $conn->error;
	}

	$conn->close();

	echo "<br>";
//Connect to database and create table
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "mainEspParking";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "CREATE TABLE arena (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	vitri VARCHAR(30),
	trangthai VARCHAR(30),
	`Time` TIME NULL, 
	`Date` DATE NULL
	)";

	if ($conn->query($sql) === TRUE) {
	    echo "Table arena created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}


	$conn->close();
