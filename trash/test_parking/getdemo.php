<?php
// Creates new record as per request
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "main_parking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Get current date and time
date_default_timezone_set('Asia/Bangkok');
$d = date("Y-m-d");
$t = date("H:i:s");

if (isset($_GET['cParkArena']) && isset($_GET['cStatus'])) {
    // Chuyển đổi giá trị trạng thái thành chuỗi tương ứng
    $cParkArena = $_GET['cParkArena'];
    $cStatus = $_GET['cStatus'];

    // Kiểm tra và gán giá trị cStatus
    if ($cStatus == 0) {
        $cStatus = 2;
    } else {
        $cStatus = 1;
    }

    // Kiểm tra xem đã có bản ghi cho cùng cParkArena hay chưa
    $checkSql = "SELECT id FROM main_table WHERE cParkArena = '$cParkArena'";
    $result = $conn->query($checkSql);

    if ($result && $result->num_rows > 0) {
        // Nếu đã có bản ghi, chỉ cập nhật bản ghi đã tồn tại
        $updateSql = "UPDATE main_table SET cName = 'Tên xe', cPlate = 'biển số xe', cTimeCheckIn = CONCAT('" . $d . "', ' ', '" . $t . "'), cTimeCheckOut = NULL, cStatus = '$cStatus' WHERE cParkArena = '$cParkArena'";
        if ($conn->query($updateSql) === TRUE) {
            echo "OK";
        } else {
            echo "Error: " . $updateSql . "<br>" . $conn->error;
        }
    } else {
        // Nếu chưa có bản ghi, thêm bản ghi mới
        $insertSql = "INSERT INTO main_table (cName, cPlate, cTimeCheckIn, cTimeCheckOut, cParkArena, cStatus)
            VALUES ('Tên xe', 'biển số xe', CONCAT('" . $d . "', ' ', '" . $t . "'), NULL, '" . $cParkArena . "', '" . $cStatus . "')";
        if ($conn->query($insertSql) === TRUE) {
            echo "OK";
        } else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
