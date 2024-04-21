<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="refresh" content="5">
    <style>
        .table-container {
            overflow-x: auto;
            overflow-y: auto;
            margin: 20px;
            border: 1px solid #ddd;
        }

        .table-container table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            white-space: nowrap;
        }

        .table-container td,
        .table-container th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table-container tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-container tr:hover {
            background-color: #ddd;
        }

        .table-container th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #00A8A9;
            color: white;
        }

        .nav-tabs {
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-item {
            margin-bottom: 0;
        }

        .nav-tabs .nav-link {
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 0;
            background-color: #f2f2f2;
            color: #333;
            padding: 10px 15px;
        }

        .nav-tabs .nav-link.active {
            background-color: #00A8A9;
            color: white;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Bãi đỗ xe thông minh</title>

</head>

<body>

    <br>



    <div class="container">
        <h1>TRƯỜNG ĐẠI HỌC GIAO THÔNG VẬN TẢI - TP. HÀ NỘI</h1>
        <h2>Mô hình quản lí bãi đỗ xe ESP thông minh</h2>
        <br>
        <?php
        //Connect to database and create table
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mainEspParking";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Database Connection failed: " . $conn->connect_error);
            echo "<a href='install.php'>If first time running click here to install database</a>";
        }
        ?>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#arena">BÃI ĐỖ XE A1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#arena2">BÃI ĐỖ XE A2</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="arena" class="tab-pane fade show active">
                <div class="table-container">
                    <table>
                        <tr>
                            <th colspan="4">BÃI ĐỖ XE A1</th>
                        </tr>
                        <tr>
                            <th>VỊ TRÍ</th>
                            <th>TRẠNG THÁI</th>
                            <th>THỜI GIAN</th>
                            <th>NGÀY</th>
                        </tr>
                        <?php
                        $sql = "(
                            SELECT * FROM arena WHERE vitri = 1 ORDER BY id desc LIMIT 1
                          )
                          UNION
                          (
                            SELECT * FROM arena WHERE vitri = 2 ORDER BY id desc LIMIT 1
                          )
                          UNION
                          (
                            SELECT * FROM arena WHERE vitri = 3 ORDER BY id desc LIMIT 1
                          )
                          UNION
                          (
                            SELECT * FROM arena WHERE vitri = 4 ORDER BY id desc LIMIT 1
                          )
                          UNION
                          (
                            SELECT * FROM arena WHERE vitri = 5 ORDER BY id desc LIMIT 1
                          )";


                        // Đếm số lượng ô tô và xe máy đã có xe đỗ
                        $countCar = 3;
                        $countMotorbike = 2;
                        if ($result = mysqli_query($conn, $sql)) {
                            // echo $sql;
                            // Fetch one and one row
                            while ($row = mysqli_fetch_row($result)) {
                                if ($row[1] == 1) {
                                    echo "<tr>";
                                    echo "<td>" . "Vị trí Ô TÔ 1" . "</td>";
                                    if ($row[2] == 1) {
                                        echo "<td>" . "Chưa có xe đỗ" . "</td>";
                                        $countCar++; // Tăng biến đếm nếu ô tô chưa đỗ
                                        if($countCar > 3){
                                            $countCar = 3;
                                        }
                                    } else if ($row[2] == 0) {
                                        echo "<td>" . "Đã có xe đỗ" . "</td>";
                                        $countCar--; // Giảm biến đếm nếu ô tô đã đỗ
                                        if($countCar < 0){
                                            $countCar = 0;
                                        }
                                    }
                                    echo "<td>" . $row[3] . "</td>";
                                    echo "<td>" . $row[4] . "</td>";
                                    echo "</tr>";
                                }
                                if ($row[1] == 2) {
                                    echo "<tr>";
                                    echo "<td>" . "vị trí Ô TÔ 2" . "</td>";
                                    if ($row[2] == 1) {
                                        echo "<td>" . "Chưa có xe đỗ" . "</td>";
                                        $countCar++; // Tăng biến đếm nếu ô tô chưa đỗ
                                        if($countCar > 3){
                                            $countCar = 3;
                                        }
                                    } else if ($row[2] == 0) {
                                        echo "<td>" . "Đã có xe đỗ" . "</td>";
                                        $countCar--; // Giảm biến đếm nếu ô tô đã đỗ
                                        if($countCar < 0){
                                            $countCar = 0;
                                        }
                                    }
                                    echo "<td>" . $row[3] . "</td>";
                                    echo "<td>" . $row[4] . "</td>";
                                    echo "</tr>";
                                }
                                if ($row[1] == 3) {
                                    echo "<tr>";
                                    echo "<td>" . "vị trí Ô TÔ 3" . "</td>";
                                    if ($row[2] == 1) {
                                        echo "<td>" . "Chưa có xe đỗ" . "</td>";
                                        $countCar++; // Tăng biến đếm nếu ô tô chưa đỗ
                                        if($countCar > 3){
                                            $countCar = 3;
                                        }
                                    } else if ($row[2] == 0) {
                                        echo "<td>" . "Đã có xe đỗ" . "</td>";
                                        $countCar--; // Giảm biến đếm nếu ô tô đã đỗ
                                        if($countCar < 0){
                                            $countCar = 0;
                                        }
                                    }
                                    echo "<td>" . $row[3] . "</td>";
                                    echo "<td>" . $row[4] . "</td>";
                                    echo "</tr>";
                                }
                                if ($row[1] == 4) {
                                    echo "<tr>";
                                    echo "<td>" . "vị trí XE MÁY 1" . "</td>";
                                    if ($row[2] == 1) {
                                        echo "<td>" . "Chưa có xe đỗ" . "</td>";
                                        $countMotorbike++; // tăng biến đếm nếu xe máy chưa đỗ
                                        if($countMotorbike > 2){
                                            $countMotorbike = 2;
                                        }
                                    } else if ($row[2] == 0) {
                                        echo "<td>" . "Đã có xe đỗ" . "</td>";
                                        $countMotorbike--; // Giảm biến đếm nếu xe máy đã có xe đỗ
                                        if($countMotorbike < 0){
                                            $countMotorbike = 0;
                                        }
                                    }
                                    echo "<td>" . $row[3] . "</td>";
                                    echo "<td>" . $row[4] . "</td>";
                                    echo "</tr>";
                                }
                                if ($row[1] == 5) {
                                    echo "<tr>";
                                    echo "<td>" . "vị trí XE MÁY 2" . "</td>";
                                    if ($row[2] == 1) {
                                        echo "<td>" . "Chưa có xe đỗ" . "</td>";
                                        $countMotorbike++; // tăng biến đếm nếu xe máy chưa đỗ
                                        if($countMotorbike > 2){
                                            $countMotorbike = 2;
                                        }
                                    } else if ($row[2] == 0) {
                                        echo "<td>" . "Đã có xe đỗ" . "</td>";
                                        $countMotorbike--; // Giảm biến đếm nếu xe máy đã có xe đỗ
                                        if($countMotorbike < 0){
                                            $countMotorbike = 0;
                                        }
                                    }
                                    echo "<td>" . $row[3] . "</td>";
                                    echo "<td>" . $row[4] . "</td>";
                                    echo "</tr>";
                                }
                            }


                            // Free result set
                            mysqli_free_result($result);
                            if ($countCar == 3 && $countMotorbike == 2) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 3 vị trí ô tô và 2 vị trí xe máy</td>";
                                echo "</tr>";
                            } elseif ($countCar == 3 && $countMotorbike == 1) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 3 vị trí ô tô và 1 vị trí xe máy</td>";
                                echo "</tr>";
                            } 
                            elseif ($countCar == 3 && $countMotorbike == 0) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 3 vị trí ô tô, xe máy mời sang bãi A2</td>";
                                echo "</tr>";
                            } 
                            elseif ($countCar == 2 && $countMotorbike == 2) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 2 vị trí ô tô và 2 vị trí xe máy</td>";
                                echo "</tr>";
                            } 
                            elseif ($countCar == 2 && $countMotorbike == 1) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 2 vị trí ô tô và 1 vị trí xe máy</td>";
                                echo "</tr>";
                            } 
                            elseif ($countCar == 2 && $countMotorbike == 0) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 2 vị trí ô tô, xe máy mời sang bãi A2</td>";
                                echo "</tr>";
                            } 
                            elseif ($countCar == 1 && $countMotorbike == 2) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 1 vị trí ô tô và 2 vị trí xe máy</td>";
                                echo "</tr>";
                            } 
                            elseif ($countCar == 1 && $countMotorbike == 1) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 1 vị trí ô tô và 1 vị trí xe máy</td>";
                                echo "</tr>";
                            } 
                            elseif ($countCar == 1 && $countMotorbike == 0) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 1 vị trí ô tô, xe máy mời sang bãi A2</td>";
                                echo "</tr>";
                            } 
                            elseif ($countCar == 0 && $countMotorbike == 2) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 2 vị trí xe máy, ô tô mời sang bãi A2</td>";
                                echo "</tr>";
                            }
                            elseif ($countCar == 0 && $countMotorbike == 1) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Còn trống 1 vị trí xe máy, ô tô mời sang bãi A2</td>";
                                echo "</tr>";
                            }
                            elseif ($countCar == 0 && $countMotorbike == 0) {
                                echo "<tr>";
                                echo "<td colspan='4'>Thông báo: Hết chỗ đỗ, mời sang bãi A2</td>";
                                echo "</tr>";
                            }    
                        }
                        ?>
                    </table>

                </div>
            </div>

            <div id="arena2" class="tab-pane fade">
                <div class="table-container">
                    <table>
                        <tr>
                            <th colspan="4">BÃI ĐỖ XE A2 - ĐANG CẬP NHẬT......</th>
                        </tr>
                        <tr>
                            <th>VỊ TRÍ</th>
                            <th>TRẠNG THÁI</th>
                            <th>THỜI GIAN</th>
                            <th>NGÀY</th>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <!-- Kết thúc Tab Content -->
</body>

</html>