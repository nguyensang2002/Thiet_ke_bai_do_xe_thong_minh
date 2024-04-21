<?php
//Creates new record as per request
//Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mainEspParking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

//Get current date and time
date_default_timezone_set('Asia/Bangkok');
$d = date("Y-m-d");
$t = date("H:i:s");

if (isset($_GET['vitri']) && isset($_GET['trangthai'])) {
    // Chuyển đổi giá trị trạng thái thành chuỗi tương ứng
    $vitri = $_GET['vitri'];
    $trangthai = $_GET['trangthai'];
    $sql = "INSERT INTO arena (vitri, trangthai, Time, Date)
		
		VALUES ('" . $vitri . "', '" . $trangthai . "', '" . $t . "', '" . $d . "')";

    if ($conn->query($sql) === TRUE) {
        echo "OK";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$conn->close();
