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
    <button class="nav-link btn btn-light " id="allrid">Tất cả</button>
    <a class="nav-link btn btn-light " href="apenride.php">Đang xử lý</a>
    <a class="nav-link btn btn-light " href="acanride.php">Đã hủy</a>
    <a class="nav-link btn btn-light " href="acomride.php">Đã hoàn thành</a>
    <button class="nav-link btn btn-light " id="ernrid">Tổng doanh thu</button>
  </nav>


  <div id="drp" class="row">
    <div class="mr-2" id="srt">
      <label for="filter">Thời gian</label>
      <select name="sort" id="sort">
        <!-- <option value="" selected hidden disabled>Khôngg</option> -->
        <option value="none">Không</option>
        <option value="week">Week</option>
        <option value="month">Month</option>
      </select>
    </div>

    <div class="mr-2" id="cstats">
      <label for="stat">Trạng thái</label>
      <select name="cstat" id="cstat">
        <option value="" selected>Tất cả</option>
        <option value="Đang xử lý">Đang xử lý</option>
        <option value="Đã hủy">Đã hủy</option>
        <option value="Đã hoàn thành">Đã hoàn thành</option>
      </select>
    </div>

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


  <div id="allr">

    <h3 class="text-center">Tất cả</h3>

    <table id='tbl' class="container-fluid col-lg-10 mr-lg-2 table  table-hover table-bordered table-striped">
      <thead>
        <th>Mã chuyến</th>
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
      <tbody id="tblc">
        <?php
        $adm = new adminwrk();
        $admc = new dbcon();
        $show = $adm->allride($admc->conn);
        foreach ($show as $key => $val) {
          echo "<tr><td>" . $val['ride_id'] . "</td><td>" . $val['ride_date'] . "</td><td>" . $val['from_distance'] . "</td><td>" . $val['to_distance'] . "</td><td>" . $val['cab_type'] . "</td><td>" . $val['total_distance'] . " Km</td><td>" . $val['luggage'] . " Kg</td><td>" . $val['total_fare'] . " VNĐ</td><td>";
          if ($val['status'] == 1) {
            echo "Đang xử lý</td>";
          }
          if ($val['status'] == 0) {
            echo "Đã hủy</td>";
          }
          if ($val['status'] == 2) {
            echo "Đã hoàn thành</td>";
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
          echo "<td><a class='btn btn-danger' onClick=\"javascript: return confirm('Vui lòng xác nhận xóa');\" href='allrides.php?action=no&id=" . $val['ride_id'] . "'>Xóa</a></td></tr></tr>";
        }
        ?>
      </tbody>

    </table>
  </div>

  <div id="ernr">
    <h3 class="text-center">Tổng doanh thu</h3>
    <?php
    $adm = new adminwrk();
    $admc = new dbcon();
    $en = $adm->earn($admc->conn);
    ?>
    <h1 class="text-center font-weight-bold text-dark">VNĐ <?php echo $en; ?></h1>
  </div>

<?php } else {
  echo '<h1 class="text-center text-weight-bold text-dark">Bạn không có quyền truy cập</h1>';
}

include('adfoot.php'); ?>