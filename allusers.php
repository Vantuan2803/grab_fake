<?php
include('adhead.php');
if (!isset($_SESSION['userdata'])) {
  header('Location: index.php');
}
if ($_SESSION['userdata']['role'] == 1) {
  include('adsidebar.php');

  if (isset($_GET['action'])) {
    $id = $_GET['id'];

    if ($_GET['action'] == 'blk') {
      $ap = 2;
      $adm = new adminwrk();
      $admc = new dbcon();
      $sho = $adm->yesno($ap, $id, $admc->conn);
    }

    if ($_GET['action'] == 'app') {
      $ap = 1;
      $adm = new adminwrk();
      $admc = new dbcon();
      $sho = $adm->yesno($ap, $id, $admc->conn);
    } elseif ($_GET['action'] == 'no') {
      $ap = 0;
      $adm = new adminwrk();
      $admc = new dbcon();
      $sho = $adm->yesno($ap, $id, $admc->conn);
    }
  }
?>

  <nav class="nav nav-pills nav-justified col-sm-10">
    <a class="nav-link btn-light active" href="allusers.php">Tất cả tài khoản</a>
    <a class="nav-link btn-light" href="aprove.php">Phê duyệt tài khoản</a>
    <a class="nav-link btn-light" href="aprovedusr.php">Tài khoản đã phê duyệt</a>
  </nav>

  <div class="center">
    <h3 class="text-center  gradient-text">Tất cả tài khoản</h3>
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
        $show = $adm->newuser($admc->conn);
        foreach ($show as $key => $val) {
          echo "<tr>
        <td>" . $val['user_id'] . "</td>
        <td>" . $val['name'] . "</td>
        <td>" . $val['user_name'] . "</td>
        <td>" . $val['dateofsignup'] . "</td>
        <td>" . $val['mobile'] . "</td>";
          echo "<td>";
          if ($val['isblock'] == 1) {
            echo "<a class='btn btn-warning' href='allusers.php?action=blk&id=" . $val['user_id'] . "'>Khóa</a>";
          } elseif ($val['isblock'] == 0) {
            echo "<a class='btn btn-success' href='allusers.php?action=app&id=" . $val['user_id'] . "'>Chấp nhận</a>";
          }
          echo "</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

<?php

} else {
  echo '<h1 class="text-center text-weight-bold text-dark">Bạn không có quyền truy cập</h1>';
}

include('adfoot.php'); ?>