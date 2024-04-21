<!DOCTYPE html>
<html>
<head>
    
    <title>Display Main Table Data</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Main Table Data</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Plate</th>
                    <th>Check-in Time</th>
                    <th>Check-out Time</th>
                    <th>Parking Arena</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // include 'getdemo.php';
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

                // Query the main_table
                $sql = "SELECT * FROM main_table";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["cName"] . "</td>";
                        echo "<td>" . $row["cPlate"] . "</td>";
                        echo "<td>" . (isset($row["cTimeCheckIn"]) ? $row["cTimeCheckIn"] : "N/A") . "</td>";
                        echo "<td>" . (isset($row["cTimeCheckOut"]) ? $row["cTimeCheckOut"] : "N/A") . "</td>";
                        echo "<td>" . $row["cParkArena"] . "</td>";
                        echo "<td>" . $row["cStatus"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No results</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
