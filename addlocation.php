<?php
include('adhead.php');
if (!isset($_SESSION['userdata'])) {
    header('Location: index.php');
}
if ($_SESSION['userdata']['role'] == 1) {
    include('adsidebar.php');

    if (isset($_GET['action'])) {
        $id = $_GET['id'];
        if ($_GET['action'] == 'yes') {
            $ap = 1;
            $adm = new adminwrk();
            $admc = new dbcon();
            $sho = $adm->dlocat($ap, $id, $admc->conn);
        }

        if ($_GET['action'] == 'apr') {
            $ap = 2;
            $adm = new adminwrk();
            $admc = new dbcon();
            $sho = $adm->dlocat($ap, $id, $admc->conn);
        }

        if ($_GET['action'] == 'no') {
            $ap = 0;
            $adm = new adminwrk();
            $admc = new dbcon();
            $sho = $adm->dlocat($ap, $id, $admc->conn);
        }
    }
?>

    <nav class="nav nav-pills col-sm-10 nav-justified">
        <a class="nav-link btn-light active" href="addlocation.php">Tất cả địa điểm</a>
        <a class="nav-link btn-light" href="locat.php">Thêm địa điểm</a>
    </nav>

    <div>
        <h3 class="text-center">All locations</h3>
    </div>
    <table id="tbl" class="container-fluid col-lg-10 table  table-hover table-bordered table-striped">
        <thead>
            <th>Mã địa điểm</th>
            <th onclick="sortTable(1,tbl)">Tên địa điểm &#9660;</th>
            <th onclick="sortTablen(2,tbl)">Quãng đường &#9660;</th>
            <!-- <th>Có sẵn</th> -->
            <th>Trạng thái</th>
            <th>Hành động</th>
        </thead>
        <tbody>
            <?php
            $adm = new adminwrk();
            $loc = new dbcon();
            $sloc = $adm->slocation($loc->conn);
            foreach ($sloc as $key => $val) {
                echo "<tr>
                <td>" . $val['id'] . "</td>
                <td>" . $val['name'] . "</td>
                <td>" . $val['distance'] . " Km</td>";
                // if ($val['is_available'] == 1) {
                //     echo "<td>Có</td>";
                // }
                // if ($val['is_available'] == 0) {
                //     echo "<td>Không</td>";
                // }
                if ($val['is_available'] == 1) {
                    echo "<td><a class='btn btn-warning' href='addlocation.php?action=yes&id=" . $val['id'] . "'>Vô hiệu hóa</a></td>";
                }
                if ($val['is_available'] == 0) {
                    echo "<td><a class='btn btn-success' href='addlocation.php?action=apr&id=" . $val['id'] . "'>Kích hoạt</a></td>";
                }
                echo "<td>
                <a class='btn btn-danger' onClick=\"javascript: return confirm('Vui lòng xác nhận xóa');\" href='addlocation.php?action=no&id=" . $val['id'] . "'>Xóa</a>
                <a class='btn btn-info' href='editloc.php?action=edit&id=" . $val['id'] . "&name=" . $val['name'] . "&distance=" . $val['distance'] . "&is_available=" . $val['is_available'] . "'>Sửa</a>
                </td>";
            }
            ?>
        </tbody>
    </table>




<?php
} else {
    echo '<h1 class="text-center text-weight-bold text-dark">Bạn không có quyền truy cập</h1>';
}
include('adfoot.php'); ?>