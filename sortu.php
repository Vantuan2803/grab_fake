<?php
session_start();
include('adminwrk.php');
$sot = $_POST['by'];
$id = $_SESSION['userdata']['user_id'];
?>
<h3 class="text-center">Tất cả</h3>

<table id='tbl' class="container-fluid col-lg-10 mr-lg-2 table  table-hover table-bordered table-striped">
    <thead>
        <th onclick="sortTable(0,tbl)">Thời gian đặt &#9660;</th>
        <th>Điểm xuất phát</th>
        <th>Điểm đến</th>
        <th>Loại xe</th>
        <th onclick="sortTablen(4,tbl)">Quãng đường &#9660;</th>
        <th onclick="sortTablen(5,tbl)">Hành lý</th>
        <th onclick="sortTablen(6,tbl)">Tổng tiền &#9660;</th>
        <th>Trạng thái</th>
        <th>Mã TK</th>
        <th>Hủy</th>
        <th>Hóa đơn</th>
    </thead>
    <tbody id='tblc'>

        <?php
        $adm = new user();
        $admc = new dbcon();
        $show = $adm->sort($sot, $id, $admc->conn);
        foreach ($show as $key => $val) {
            echo "<tr><td>" . $val['ride_date'] . "</td><td>" . $val['from_distance'] . "</td><td>" . $val['to_distance'] . "</td><td>" . $val['cab_type'] . "</td><td>" . $val['total_distance'] . " Km</td><td>" . $val['luggage'] . " Kg</td><td>" . $val['total_fare'] . "</td><td>";
            if ($val['status'] == 1) {
                echo "Pending</td>";
            }
            if ($val['status'] == 0) {
                echo "Canceled</td>";
            }
            if ($val['status'] == 2) {
                echo "Completed</td>";
            }
            echo  "<td>" . $val['customer_user_id'] . "</td>";

            if ($val['status'] == 1) {
                echo "<td><a class='btn btn-warning' href='allrides.php?action=blk&id=" . $val['ride_id'] . "'>Hủy</a></td>";
            } else {
                echo "<td><a class='btn btn-warning disabled' >Hủy</a></td>";
            }
            if ($val['status'] == 2) {
                echo "<td><a class='btn btn-info' href='invoiceu.php?id=" . $val['ride_id'] . "'>Hóa đơn</a></td>";
            } else {
                echo "<td><a class='btn btn-info disabled'>Hóa đơn</a></td>";
            }
        }

        echo  '</tbody></table>';
        ?>