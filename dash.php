<?php
session_start();
if (!isset($_SESSION['userdata'])) {
  header('Location: index.php');
}
if ($_SESSION['userdata']['role'] == 1) {
  include('header.php');
  echo '<header>
  <nav  class="navbar navbar-expand-lg">
      <a class="navbar-brand nos" href="#">Grab<span class="logo-header">Fake</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span><i class="fas fa-bars logo text-dark"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item rbtn">
                  <a class="btn" href="admin.php">Hoạt động</a>
                  <a class="btn" href="logout.php">Đăng xuất</a>
              </li>
          </ul>
      </div>
  </nav>
</header>';
  echo '<h1 class="text-center text-weight-bold text-dark">ADMIN không được phép truy cập vào khu vực người dùng</h1>';
} else {
  $id = $_SESSION['userdata']['user_id'];
  include('user.php');
  include('header.php');
  include('navs.php');
  include('ussidebar.php');
?>

  <div class="row-center">
    <?php if ($_SESSION['userdata']['role'] == 3) { ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card bg-success text-center">
          <div class="card-body">
            <i class="fas fa-taxi po"></i>
            <h5 class="card-title ">Tất cả chuyến đi</h5>
            <p class="card-text font-weight-bold text-dark h1">
              <?php
              $adm = new user();
              $admc = new dbcon();
              $cn = $adm->countride($id, $admc->conn);
              print_r($cn); ?></p>
            <a href="usrride.php" class="btn btn-primary green">Chi tiết</a>
          </div>
        </div>
      </div>
    <?php } ?>

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-warning text-center">
        <div class="card-body">
          <i class="fas fa-car po"></i>
          <h5 class="card-title">Chuyến đi đang chờ xử lý</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $role = $_SESSION['userdata']['role'];
            $adm = new user();
            $admc = new dbcon();
            $cn = $adm->pcountride($id, $role, $_SESSION['userdata']['cab_type'], $admc->conn);
            print_r($cn); ?></p>
          <a href="upenride.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-info text-center">
        <div class="card-body">
          <i class="fas fa-check po"></i>
          <h5 class="card-title">Chuyến đi đã hoàn thành</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $cn = $adm->cocountride($id, $role, $admc->conn);
            print_r($cn); ?></p>
          <a href="ucomride.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

  </div>

  <div class="row-center">

    <?php if ($_SESSION['userdata']['role'] == 3) { ?>
      <div class="col-sm-6 col-lg-3 ">
        <div class="card bg-success text-center">
          <div class="card-body">
            <i class="fas fa-times po"></i>
            <h5 class="card-title">Chuyến đi đã hủy</h5>
            <p class="card-text font-weight-bold text-dark h1">
              <?php
              $cn = $adm->cacountride($id, $admc->conn);
              print_r($cn); ?></p>
            <a href="ucanride.php" class="btn btn-primary green">Chi tiết</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3 ">
        <div class="card bg-warning text-center">
          <div class="card-body">
            <h2 class="card-title">Tổng chi tiêu</h2>
            <p class="card-text font-weight-bold text-dark h4">
              <?php
              $en = $adm->earn($id, $admc->conn);
              ?>VNĐ <?php echo $en; ?>000</p>
            <p>cho các chuyến đi đã hoàn thành</p>
          </div>
        </div>
      </div>
    <?php } ?>

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-info text-center">
        <div class="card-body">
          <i class="fas fa-user-edit po"></i>
          <h5 class="card-title">Chỉnh sửa</h5>
          <p class="card-text font-weight-bold text-dark h1">Thông tin</p>
          <a href="usrprofile.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

  </div>

<?php

  if (isset($_SESSION['book'])) {
    unset($_SESSION['book']);
  }

  include('adfoot.php');
} ?>