<?php
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
$sql = "CREATE DATABASE IF NOT EXISTS main_parking";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

echo "<br>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "main_parking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS main_table (
    id INT(11) NOT NULL AUTO_INCREMENT,
    cName VARCHAR(255) NOT NULL DEFAULT 'N/A',
    cPlate VARCHAR(255) NOT NULL DEFAULT 'N/A',
    cTimeCheckIn TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    cTimeCheckOut TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    cParkArena VARCHAR(30) NOT NULL,
    cStatus VARCHAR(30) NOT NULL DEFAULT 1,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql) === TRUE) {
    echo "Table main_table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS parking_arena (
    id INT(11) NOT NULL AUTO_INCREMENT,
    idParkArena INT(11) NOT NULL,
    parkName VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
    parkLocation INT(11) NOT NULL,
    description VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

if ($conn->query($sql) === TRUE) {
    echo "Table parking_arena created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS status_code (
    id INT(11) NOT NULL AUTO_INCREMENT,
    sId INT(11) NOT NULL,
    description VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

if ($conn->query($sql) === TRUE) {
    echo "Table status_code created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
