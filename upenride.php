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
    if ($_GET['action'] == 'app') {
      $id = $_GET['id'];
      $driver_id = $_GET['driver_id'];
      $ap = 1;
      $adm = new user();
      $admc = new dbcon();
      $sho = $adm->rideup($ap, $id, $driver_id, $admc->conn);
    }
  }
  include('header.php');
  include('navs.php');
  include('ussidebar.php');
?>
  <nav class="nav nav-pills nav-justified col-sm-10">
    <?php if ($_SESSION['userdata']['role'] == 3) : ?>
      <a class="nav-link btn btn-light " href="usrride.php">Tất cả</a>
    <?php endif; ?>
    <a class="nav-link btn btn-light " href="upenride.php">Đang xử lý</a>
    <?php if ($_SESSION['userdata']['role'] == 3) : ?>
    <a class="nav-link btn btn-light " href="ucanride.php">Đã hủy</a>
    <?php endif; ?>
    <a class="nav-link btn btn-light " href="ucomride.php">Đã hoàn thành</a>
  </nav>

  <div class="center" id="penru">
    <h3 class="text-center gradient-text">Đang xử lý</h3>
    <table id='tbl2' class="container-fluid col-lg-10 mr-lg-2 table table-hover table-bordered table-striped">
      <thead>
        <th onclick="sortTable(0,tbl2)">Thời gian đặt &#9660;</th>
        <th>Điểm xuất phát</th>
        <th>Điểm đến</th>
        <th>Loại xe</th>
        <th onclick="sortTablen(4,tbl2)">Quãng đường &#9660;</th>
        <th>Hành lý</th>
        <th onclick="sortTablen(6,tbl2)">Tổng tiền &#9660;</th>
        <th>Trạng thái</th>
        <!-- <th>Mã TK</th> -->
        <?php if ($_SESSION['userdata']['role'] == 3) : ?>
          <th>Hủy</th>
        <?php elseif ($_SESSION['userdata']['role'] == 2) : ?>
          <th>Chấp nhận</th>
        <?php endif; ?>
      </thead>
      <tbody id="tbl2c">
        <?php
        function getCabName ($type, $admc) {
          $car = '';
          $sql = "SELECT * FROM `vehicle` WHERE `id` = " . $type;
          $res = $admc->conn->query($sql);
          if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
              $car = $row['name'];
            }
          }
          return $car;
        } ;
        $id = $_SESSION['userdata']['user_id'];
        $adm = new user();
        $admc = new dbcon();
        $showp = $_SESSION['userdata']['role'] == 2? $adm->pendriver($_SESSION['userdata']['cab_type'],$admc->conn) :$adm->penride($id, $admc->conn);
        foreach ($showp as $key => $val) {
          echo "<tr>
          <td>" . $val['ride_date'] . "</td>
          <td>" . $val['from_distance'] . "</td>
          <td>" . $val['to_distance'] . "</td>
          <td>" . getCabName($val['cab_type'], $admc) . "</td>
          <td>" . $val['total_distance'] . " Km</td>
          <td>" . $val['luggage'] . " Kg</td>
          <td>" . $val['total_fare'] . " VNĐ</td>
          <td>Đang xử lý</td>";
          if($_SESSION['userdata']['role'] == 3){
            if ($val['status'] == 0) {
              echo "<td><a class='btn btn-warning' href='upenride.php?action=blk&id=" . $val['ride_id'] . "'>Hủy</a></td>";
            } else {
              echo "<td><a class='btn btn-warning disabled' >Hủy</a></td>";
            }
          } elseif($_SESSION['userdata']['role'] == 2){
            echo "<td><a class='btn btn-success' href='upenride.php?action=app&id=" . $val['ride_id'] . "&driver_id=".$_SESSION['userdata']['user_id']."'>Chấp nhận</a></td>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
<?php include('adfoot.php');
} ?>