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
    <a class="nav-link btn btn-light " href="usrride.php">Tất cả</a>
    <a class="nav-link btn btn-light " href="upenride.php">Đang xử lý</a>
    <a class="nav-link btn btn-light " href="ucanride.php">Đã hủy</a>
    <a class="nav-link btn btn-light " href="ucomride.php">Đã hoàn thành</a>
  </nav>

  <div id="drp" class="row p-2">
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

  <div class="center" id="canru">
    <h3 class="text-center gradient-text">Đã hủy</h3>
    <table id="tbl3" class="container-fluid col-lg-10 mr-lg-2 table table-hover table-bordered table-striped">
      <thead>
        <th onclick="sortTable(0,tbl3)">Thời gian đặt &#9660;</th>
        <th>Điểm xuất phát</th>
        <th>Điểm đến</th>
        <th>Loại xe</th>
        <th onclick="sortTablen(4,tbl3)">Quãng đường &#9660;</th>
        <th onclick="sortTable(5,tbl3)">Hành lý</th>
        <th onclick="sortTable(6,tbl3)">Tổng tiền &#9660;</th>
        <th>Trạng thái</th>
      </thead>
      <tbody id="tbl3c">
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
        $showc = $adm->canride($id, $admc->conn);
        foreach ($showc as $key => $val) {
          echo "<tr>
          <td>" . $val['ride_date'] . "</td>
          <td>" . $val['from_distance'] . "</td>
          <td>" . $val['to_distance'] . "</td>
          <td>" . getCabName($val['cab_type'],$admc) . "</td>
          <td>" . $val['total_distance'] . " Km</td>
          <td>" . $val['luggage'] . " Kg</td>
          <td>" . $val['total_fare'] . " VNĐ</td>
          <td>Đã hủy</td>";
          // echo  "<td>" . $val['customer_user_id'] . "</td>";
        }
        ?>
      </tbody>

    </table>
  </div>

<?php include('adfoot.php');
} ?>