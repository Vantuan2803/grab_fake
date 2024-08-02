<?php
session_start();
if (!isset($_SESSION['userdata'])) {
  header('Location: index.php');
}
if ($_SESSION['userdata']['role'] == 1) {
  include('header.php');
  include('adminwrk.php');
?>
  <header>
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand nos" href="#">Grab<span class="logo-header">Fake</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fas fa-bars logo text-dark"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item rbtn">
            <a class="btn" href="admin.php">Dashboard</a>
            <a class="btn" href="logout.php">Đăng xuất</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
<?php
  echo '<h1 class="text-center text-weight-bold text-dark">ADMIN can not Enter User Area</h1>';
} else {
  include('user.php');

  if (isset($_GET['action'])) {
    if ($_GET['action'] == 'blk') {
      $id = $_GET['id'];
      $ap = 1;
      $adm = new user();
      $admc = new dbcon();
      $sho = $adm->ridec($ap, $id, $admc->conn);
    }
  }
  include('header.php');

  include('navs.php');

  include('ussidebar.php');


?>
  <nav class="nav nav-pills nav-justified col-sm-10">
    <?php if ($_SESSION['userdata']['role'] == 3) : ?>
      <button class="nav-link btn btn-light " id="allridu">Tất cả</button>
    <?php endif; ?>
    <a class="nav-link btn btn-light " href="upenride.php">Đang xử lý</a>
    <a class="nav-link btn btn-light " href="ucomride.php">Đã hoành thành</a>
    <?php if ($_SESSION['userdata']['role'] == 3) : ?>
      <a class="nav-link btn btn-light " href="ucanride.php">Đã hủy</a>
      <button class="nav-link btn btn-light " id="ernridu">Tổng chi tiêu</button>
    <?php endif; ?>
  </nav>

  <div id="drp" class="row p-2">
    <div class="mr-2" id="srt">
      <label for="sorting">Thời gian</label>
      <select name="sortu" id="sortu">
        <!-- <option value="" selected hidden disabled>Không</option> -->
        <option value="none">Không</option>
        <option value="week">Tuần</option>
        <option value="month">Tháng</option>
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
        <option value="2">Xe Máy</option>
        <option value="1">Xe Điện</option>
        <option value="3">Xe oto 4 chỗ</option>
        <option value="4">Xe oto 7 chỗ</option>
      </select>
    </div>
  </div>

  <div class="center" id="allru">
    <h3 class="text-center gradient-text">Tất cả chuyến đi</h3>
    <table id="tbl" class="container-fluid col-lg-10 mr-lg-2 table table-hover table-bordered table-striped">
      <thead>
        <th onclick="sortTable(0,tbl)">Thời gian đặt &#9660;</th>
        <th>Điểm xuất phát</th>
        <th>Điểm đến</th>
        <th>Loại xe</th>
        <th onclick="sortTablen(4,tbl)">Quãng đường &#9660;</th>
        <th onclick="sortTablen(5,tbl)">Hành lý</th>
        <th onclick="sortTablen(6,tbl)">Tổng tiền &#9660;</th>
        <th>Trạng thái</th>
        <?php if ($_SESSION['userdata']['role'] == 3) : ?>
          <th>Hủy</th>
        <?php elseif ($_SESSION['userdata']['role'] == 2) : ?>
          <th>Chấp nhận</th>
        <?php endif; ?>
        <th>Hóa đơn</th>
      </thead>
      <tbody id="tblc">
        <?php
        function getCabName($type, $admc)
        {
          $car = '';
          $sql = "SELECT * FROM `vehicle` WHERE `id` = " . $type;
          $res = $admc->conn->query($sql);
          if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
              $car = $row['name'];
            }
          }
          return $car;
        };
        $id = $_SESSION['userdata']['user_id'];
        $adm = new user();
        $admc = new dbcon();
        $showr = $adm->allride($id, $admc->conn);
        foreach ($showr as $key => $val) {
          echo "<tr>
          <td>" . $val['ride_date'] . "</td>
          <td>" . $val['from_distance'] . "</td>
          <td>" . $val['to_distance'] . "</td>
          <td>" . getCabName($val['cab_type'], $admc) . "</td>
          <td>" . $val['total_distance'] . " Km</td>
          <td>" . $val['luggage'] . " Kg</td>
          <td>" . $val['total_fare'] . " VNĐ</td>
          <td>";
          if ($val['status'] == 1) {
            echo "Đang xử lý</td>";
          }
          if ($val['status'] == 0) {
            echo "Đã hủy</td>";
          }
          if ($val['status'] == 2) {
            echo "Đã hoàn thành</td>";
          }
          // echo  "<td>" . $val['customer_user_id'] . "</td>";
          if ($val['status'] == 1) {
            echo "<td><a class='btn btn-warning' href='usrride.php?action=blk&id=" . $val['ride_id'] . "'>Hủy</a></td>";
          } else {
            echo "<td><a class='btn btn-warning disabled'>Hủy</a></td>";
          }
          if ($val['status'] == 2) {
            echo "<td><a class='btn btn-info' href='invoiceu.php?id=" . $val['ride_id'] . "'>Chi tiết</a></td>";
          } else {
            echo "<td><a class='btn btn-info disabled'>Chi tiết</a></td>";
          }
        }
        ?>
      </tbody>

    </table>
  </div>

  <div id="ernru" class="p-5">
    <h3 class="text-center">Bạn đã chi tiêu số tiền cho các chuyến đi là:</h3>
    <?php
    $id = $_SESSION['userdata']['user_id'];
    $adm = new user();
    $admc = new dbcon();
    $en = $adm->earn($id, $admc->conn);
    ?>
    <h1 class="text-center font-weight-bold text-dark">VNĐ <?php echo $en; ?>000</h1>
  </div>
<?php include('adfoot.php');
} ?>