<?php
session_start();
include('adminwrk.php');
$sot = $_POST['by'];
$id = $_SESSION['userdata']['user_id'];

?>
<h3 class="text-center">Tất cả</h3>

<table id='tbl' class="container-fluid col-lg-10 mr-lg-2 table  table-hover table-bordered table-striped">
    <thead>
        <th>Ride id</th>
        <th onclick="sortTable(1,tbl)">Thời gian đặt &#9660;</th>
        <th>Điểm xuất phát</th>
        <th>Điểm đến</th>
        <th>Loại xe</th>
        <th onclick="sortTablen(5,tbl)">Quãng đường &#9660;</th>
        <th>Hành lý</th>
        <th onclick="sortTablen(7,tbl)">Tổng tiền &#9660;</th>
        <th>Trạng thái</th>
        <th>Mã TK</th>
        <th>Hủy</th>
        <th>Chấp nhận</th>
        <th>Hóa đơn</th>
        <th>Xóa</th>
    </thead>
    <tbody id='tblc'>

        <?php
        $adm = new adminwrk();
        $admc = new dbcon();
        $show = $adm->sort($sot, $id, $admc->conn);
        foreach ($show as $key => $val) {
            echo "<tr><td>" . $val['ride_id'] . "</td><td>" . $val['ride_date'] . "</td><td>" . $val['from_distance'] . "</td><td>" . $val['to_distance'] . "</td><td>" . $val['cab_type'] . "</td><td>" . $val['total_distance'] . " Km</td><td>" . $val['luggage'] . " Kg</td><td>" . $val['total_fare'] . "</td><td>";
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

                echo "<td><a class='btn btn-success' href='allrides.php?action=app&id=" . $val['ride_id'] . "'>Chấp nhận</a></td>";
            } else {
                echo "<td><a class='btn btn-warning disabled' >Hủy</a></td>";

                echo "<td><a class='btn btn-success disabled' >Chấp nhận</a></td>";
            }
            if ($val['status'] == 2) {
                echo "<td><a class='btn btn-info' href='invoice.php?id=" . $val['ride_id'] . "'>Hóa đơn</a></td>";
            } else {
                echo "<td><a class='btn btn-info disabled'>Hóa đơn</a></td>";
            }
            echo "<td><a class='btn btn-danger' href='allrides.php?action=no&id=" . $val['ride_id'] . "'>Xóa</a></td></tr>";
        }
        echo  '</tbody>

            </table>';

        ?>