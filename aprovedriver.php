<?php
include('adhead.php');
if ($_SESSION['userdata']['role'] == 1) {
  if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_GET['action'] == 'yes') {
      $ap = 1;
    } elseif ($_GET['action'] == 'no') {
      $ap = 0;
    }
    $adm = new adminwrk();
    $admc = new dbcon();
    $sho = $adm->yesno($ap, $id, $admc->conn);
  }
  include('adsidebar.php');
?>
  <nav class="nav nav-pills nav-justified col-sm-10">
    <a class="nav-link btn-light" href="alldrivers.php">Tất cả tài khoản</a>
    <a class="nav-link btn-light active" href="aprovedriver.php">Phê duyệt tài khoản</a>
    <a class="nav-link btn-light" href="aproveddriver.php">Tài khoản đã phê duyệt</a>
  </nav>

  <div class="center">
    <h3 class="text-center gradient-text">Phê duyệt tài khoản</h3>
    <table id="tbl" class="container-fluid col-lg-10 mr-lg-2 table  table-hover table-bordered table-striped">
      <thead>
        <tr>
          <th>Mã tài khoản</th>
          <th onclick="sortTable(1,'tbl')">Họ tên</th>
          <th onclick="sortTable(2,'tbl')">Email</th>
          <th onclick="sortTable(3,'tbl')">Ngày đăng ký</th>
          <th onclick="sortTable(4,'tbl')">Số điện thoại</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $adm = new adminwrk();
        $admc = new dbcon();
        $show = $adm->aproveDriver($admc->conn);
        foreach ($show as $key => $val) {
          echo "<tr>
                  <td>" . $val['user_id'] . "</td>
                  <td>" . $val['name'] . "</td>
                  <td>" . $val['user_name'] . "</td>
                  <td>" . $val['dateofsignup'] . "</td>
                  <td>" . $val['mobile'] . "</td>
                  <td><a class='btn btn-success' href='aprovedriver.php?action=yes&id=" . $val['user_id'] . "'>Chấp nhận</a></td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

<?php
} else {
  echo '<h1 class="text-center text-weight-bold text-dark">Bạn không có quyền truy cập</h1>';
}

include('adfoot.php');
?>