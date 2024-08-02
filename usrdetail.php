<?php
include('adhead.php');
$id = $_GET['id'];
$_SESSION['temp'] = $id;
if (isset($_GET['action'])) {
  $d = $_GET['d'];

  if ($_GET['action'] == 'blk') {
    $ap = 2;
    $adm = new adminwrk();
    $admc = new dbcon();
    $sho = $adm->rideup($ap, $d, $admc->conn);
  }

  if ($_GET['action'] == 'app') {
    $ap = 1;
    $adm = new adminwrk();
    $admc = new dbcon();
    $sho = $adm->rideup($ap, $d, $admc->conn);
  } elseif ($_GET['action'] == 'no') {
    $ap = 0;
    $adm = new adminwrk();
    $admc = new dbcon();
    $sho = $adm->rideup($ap, $d, $admc->conn);
  }
}

include('adsidebar.php');
$adm = new adminwrk();
$admc = new dbcon();
$usr = $adm->ialluser($id, $admc->conn);
foreach ($usr as $key1 => $val1) {
  $name = $val1['name'];
  $email = $val1['user_name'];
  $mob = $val1['mobile'];
}

?>
<nav class="nav nav-pills nav-justified col-sm-10">
  <button class="nav-link btn btn-light " id="allridu">Tất cả</button>
  <button class="nav-link btn btn-light " id="penridu">Đang xử lý</button>
  <button class="nav-link btn btn-light " id="canridu">Đã hủy</button>
  <button class="nav-link btn btn-light " id="comridu">Đã hoàn thành</button>
  <button class="nav-link btn btn-light " id="ernridu">Total Spending</button>
</nav>

<div id="drp" class="row">

  <div class="mr-2" id="srt">
    <label for="sorting">FILTER BY</label>
    <select name="sortud" id="sortud">
      <option value="" selected hidden disabled>FILTER BY</option>
      <option value="none">Không</option>
      <option value="week">Week</option>
      <option value="month">Month</option>
    </select>
  </div>

  <div class="mr-2" id="cstats">
    <label for="stat">Booking Status</label>
    <select name="cstat" id="cstat">
      <option value="" selected>Tất cả</option>
      <option value="Pending">Đang xử lý</option>
      <option value="Canceled">Đã hủy</option>
      <option value="Completed">Đã hoàn thành</option>
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

<div>
  <label class=" ">Name : <?php echo $name; ?></label><br>
  <label class="">E-mail : <?php echo $email; ?></label><br>
  <label class="">Mobile : <?php echo $mob; ?></label>
</div>
<div id="allru">

  <h3 class="text-center">Tất cả</h3>

  <table id="tbl" class="container-fluid col-lg-10 mr-lg-2 table  table-hover table-bordered table-striped">
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
      <th>Chấp nhận</th>
      <th>Hóa đơn</th>
      <th>Xóa</th>
    </thead>
    <tbody id="tblc">
      <?php

      $adm = new adminwrk();
      $admc = new dbcon();
      $showr = $adm->allrideu($id, $admc->conn);
      foreach ($showr as $key => $val) {
        echo "<tr><td>" . $val['ride_date'] . "</td><td>" . $val['from_distance'] . "</td><td>" . $val['to_distance'] . "</td><td>" . $val['cab_type'] . "</td><td>" . $val['total_distance'] . " Km</td><td>" . $val['luggage'] . " Kg</td><td>" . $val['total_fare'] . " VNĐ</td><td>";
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
          echo "<td><a class='btn btn-warning' href='usrdetail.php?action=blk&id=" . $id . "&d=" . $val['ride_id'] . "'>Hủy</a></td>";

          echo "<td><a class='btn btn-success' href='usrdetail.php?action=app&&id=" . $id . "&d=" . $val['ride_id'] . "'>Chấp nhận</a></td>";
        } else {
          echo "<td><a class='btn btn-warning disabled' >Hủy</a></td>";

          echo "<td><a class='btn btn-success disabled' >Chấp nhận</a></td>";
        }
        if ($val['status'] == 2) {
          echo "<td><a class='btn btn-info' href='invoice.php?id=" . $val['ride_id'] . "'>Hóa đơn</a></td>";
        } else {
          echo "<td><a class='btn btn-info disabled'>Hóa đơn</a></td>";
        }
        echo "<td><a class='btn btn-danger' href='usrdetail.php?action=no&id=" . $id . "&d=" . $val['ride_id'] . "'>Xóa</a></td></tr></tr>";
      }
      ?>
    </tbody>

  </table>
</div>

<div id="penru">
  <h3 class="text-center">Đang xử lý</h3>
  <table id="tbl1" class="container-fluid col-lg-10 mr-lg-2 table  table-hover table-bordered table-striped">
    <thead>
      <th onclick="sortTable(0,tbl1)">Thời gian đặt &#9660;</th>
      <th>Điểm xuất phát</th>
      <th>Điểm đến</th>
      <th>Loại xe</th>
      <th onclick="sortTablen(4,tbl1)">Quãng đường &#9660;</th>
      <th onclick="sortTablen(5,tbl1)">Hành lý</th>
      <th onclick="sortTablen(6,tbl1)">Tổng tiền &#9660;</th>
      <th>Trạng thái</th>
      <th>Mã TK</th>
      <th>Hủy</th>
    </thead>
    <tbody id="tbl1c">
      <?php
      $showp = $adm->penrideu($id, $admc->conn);
      foreach ($showp as $key => $val) {
        echo "<tr><td>" . $val['ride_date'] . "</td><td>" . $val['from_distance'] . "</td><td>" . $val['to_distance'] . "</td><td>" . $val['cab_type'] . "</td><td>" . $val['total_distance'] . " Km</td><td>" . $val['luggage'] . " Kg</td><td>" . $val['total_fare'] . "</td><td>";

        echo "Pending</td>";

        echo  "<td>" . $val['customer_user_id'] . "</td>";

        if ($val['status'] == 1) {
          echo "<td><a class='btn btn-warning' href='usrride.php?action=blk&id=" . $val['ride_id'] . "'>Hủy</a></td>";
        } else {
          echo "<td><a class='btn btn-warning disabled' >Hủy</a></td>";
        }
      }
      ?>
    </tbody>
  </table>
</div>

<div id="canru">
  <h3 class="text-center">Đã hủy</h3>
  <table id="tbl2" class="container-fluid col-lg-10 mr-lg-2 table  table-hover table-bordered table-striped">
    <thead>
      <th onclick="sortTable(0,tbl2)">Thời gian đặt &#9660;</th>
      <th>Điểm xuất phát</th>
      <th>Điểm đến</th>
      <th>Loại xe</th>
      <th onclick="sortTablen(4,tbl2)">Quãng đường &#9660;</th>
      <th onclick="sortTablen(5,tbl2)">Hành lý</th>
      <th onclick="sortTablen(6,tbl2)">Tổng tiền &#9660;</th>
      <th>Trạng thái</th>
      <th>Mã TK</th>
    </thead>
    <tbody id="tbl2c">
      <?php
      $showc = $adm->canrideu($id, $admc->conn);
      foreach ($showc as $key => $val) {
        echo "<tr><td>" . $val['ride_date'] . "</td><td>" . $val['from_distance'] . "</td><td>" . $val['to_distance'] . "</td><td>" . $val['cab_type'] . "</td><td>" . $val['total_distance'] . " Km</td><td>" . $val['luggage'] . " Kg</td><td>" . $val['total_fare'] . "</td><td>";

        echo "Canceled</td>";

        echo  "<td>" . $val['customer_user_id'] . "</td>";
      }
      ?>
    </tbody>
  </table>
</div>

<div id="comru">
  <h3 class="text-center">Đã hoàn thành</h3>
  <table id="tbl3" class="container-fluid col-lg-10 mr-lg-2 table  table-hover table-bordered table-striped">
    <thead>
      <th onclick="sortTable(0,tbl3)">Thời gian đặt &#9660;</th>
      <th>Điểm xuất phát</th>
      <th>Điểm đến</th>
      <th>Loại xe</th>
      <th onclick="sortTablen(4,tbl3)">Quãng đường &#9660;</th>
      <th onclick="sortTablen(5,tbl3)">Hành lý</th>
      <th onclick="sortTablen(6,tbl3)">Tổng tiền &#9660;</th>
      <th>Trạng thái</th>
      <th>Mã TK</th>
      <th>Hóa đơn</th>
    </thead>
    <tbody id="tbl3c">
      <?php
      $showm = $adm->comrideu($id, $admc->conn);
      foreach ($showm as $key => $val) {
        echo "<tr><td>" . $val['ride_date'] . "</td><td>" . $val['from_distance'] . "</td><td>" . $val['to_distance'] . "</td><td>" . $val['cab_type'] . "</td><td>" . $val['total_distance'] . " Km</td><td>" . $val['luggage'] . " Kg</td><td>" . $val['total_fare'] . "</td><td>";
        echo "Completed</td>";
        echo  "<td>" . $val['customer_user_id'] . "</td>";
        echo "<td><a class='btn btn-info' href='invoice.php?id=" . $val['ride_id'] . "'>Hóa đơn</a></td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<div id="ernru">
  <h3 class="text-center">Total Spending</h3>
  <?php
  $en = $adm->earnu($id, $admc->conn);
  ?>
  <h1 class="text-center font-weight-bold text-dark">VNĐ <?php echo $en; ?></h1>
</div>

<?php include('adfoot.php'); ?>