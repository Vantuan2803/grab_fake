<?php
include('adhead.php');
if (!isset($_SESSION['userdata'])) {
  header('Location: index.php');
}
if ($_SESSION['userdata']['role'] == 1) {
  include('adsidebar.php');
  $id = $_SESSION['userdata']['user_id'];
  if (isset($_GET['action'])) {
    $id = $_GET['id'];

    if ($_GET['action'] == 'blk') {
      $ap = 2;
      $adm = new adminwrk();
      $admc = new dbcon();
      $sho = $adm->rideup($ap, $id, $admc->conn);
    }

    if ($_GET['action'] == 'app') {
      $ap = 1;
      $adm = new adminwrk();
      $admc = new dbcon();
      $sho = $adm->rideup($ap, $id, $admc->conn);
    } elseif ($_GET['action'] == 'no') {
      $ap = 0;
      $adm = new adminwrk();
      $admc = new dbcon();
      $sho = $adm->rideup($ap, $id, $admc->conn);
    }
  }

?>

  <nav class="nav nav-pills nav-justified col-sm-10">
    <a class="nav-link btn btn-light " href="allrides.php">Tất cả</a>
    <a class="nav-link btn btn-light " href="apenride.php">Đang xử lý</a>
    <a class="nav-link btn btn-light " href="acanride.php">Đã hủy</a>
    <a class="nav-link btn btn-light " href="acomride.php">Đã hoàn thành</a>
  </nav>

  <div id="drp" class="row">

    <div class="mr-2" id="cfilt">
      <label for="filter">Loại xe</label>
      <select name="cfil" id="cfil">
        <option value="" selected>Không</option>
        <option value="Xe Máy">Xe Máy</option>
        <option value="Xe Điện">Xe Điện</option>
        <option value="Xe oto 4 chỗ">Xe oto 4 chỗ</option>
        <option value="Xe oto 7 chỗ">Xe oto 7 chỗ</option>
      </select>
    </div>
  </div>

  <div id="penr">

    <h3 class="text-center">Đang xử lý</h3>

    <table id='tbl1' class="container-fluid col-lg-10 mr-lg-2 table  table-hover table-bordered table-striped">
      <thead>
        <th>Ride id</th>
        <th onclick="sortTable(1,tbl1)">Thời gian đặt &#9660;</th>
        <th>Điểm xuất phát</th>
        <th>Điểm đến</th>
        <th>Loại xe</th>
        <th onclick="sortTablen(5,tbl1)">Quãng đường &#9660;</th>
        <th>Hành lý</th>
        <th onclick="sortTablen(7,tbl1)">Tổng tiền &#9660;</th>
        <th>Trạng thái</th>
        <th>Mã TK</th>
        <th>Hủy</th>
        <th>Chấp nhận</th>
        <th>Xóa</th>
      </thead>
      <tbody id="tbl1c">
        <?php
        $adm = new adminwrk();
        $admc = new dbcon();
        $pen = $adm->penride($admc->conn);
        foreach ($pen as $key => $val) {
          echo "<tr><td>" . $val['ride_id'] . "</td><td>" . $val['ride_date'] . "</td><td>" . $val['from_distance'] . "</td><td>" . $val['to_distance'] . "</td><td>" . $val['cab_type'] . "</td><td>" . $val['total_distance'] . " Km</td><td>" . $val['luggage'] . " Kg</td><td>" . $val['total_fare'] . " VNĐ</td><td>";
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
            echo "<td><a class='btn btn-warning' href='apenride.php?action=blk&id=" . $val['ride_id'] . "'>Hủy</a></td>";

            echo "<td><a class='btn btn-success' href='apenride.php?action=app&id=" . $val['ride_id'] . "'>Chấp nhận</a></td>";
          } else {
            echo "<td><a class='btn btn-warning disabled' >Hủy</a></td>";

            echo "<td><a class='btn btn-success disabled' >Chấp nhận</a></td>";
          }
          echo "<td><a class='btn btn-danger' onClick=\"javascript: return confirm('Vui lòng xác nhận xóa');\" href='apenride.php?action=no&id=" . $val['ride_id'] . "'>Xóa</a></td></tr></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

<?php } else {
  echo '<h1 class="text-center text-weight-bold text-dark">Bạn không có quyền truy cập</h1>';
}

include('adfoot.php'); ?>