<?php
include('adhead.php');
if (!isset($_SESSION['userdata'])) {
  header('Location: index.php');
}
if ($_SESSION['userdata']['role'] == 1) {
  include('adsidebar.php'); ?>

  <h3 class="text-center">Chào mừng <?php echo $_SESSION['userdata']['username']; ?></h3>

  <div class="row-center">

    <div class="col-sm-6 col-lg-3">
      <div class="card bg-success text-center">
        <div class="card-body">
          <h5 class="card-title ">Tất cả chuyến đi</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $adm = new adminwrk();
            $admc = new dbcon();
            $cn = $adm->countride($admc->conn);
            print_r($cn); ?></p>
          <a href="allrides.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-warning text-center">
        <div class="card-body">
          <h5 class="card-title">Chuyến đi đang xử lý</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $cn = $adm->pcountride($admc->conn);
            print_r($cn); ?></p>
          <a href="apenride.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-info text-center">
        <div class="card-body">
          <h5 class="card-title">Chuyến đi đã hoàn thành</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $cn = $adm->cocountride($admc->conn);
            print_r($cn); ?></p>
          <a href="acomride.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

  </div>

  <div class="row-center">

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-success text-center">
        <div class="card-body">
          <h5 class="card-title">Chuyến đi đã hủy</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $cn = $adm->cacountride($admc->conn);
            print_r($cn); ?></p>
          <a href="acanride.php" href="allrides.php#penr" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-warning text-center">
        <div class="card-body">
          <h5 class="card-title">Doanh thu</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $en = $adm->earn($admc->conn);
            ?>VNĐ <?php echo $en; ?></p>
          <p>Các chuyến đi đã hoàn thành</p>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-info text-center">
        <div class="card-body">
          <h5 class="card-title">Tất cả tài khoản</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $us = $adm->countuser($admc->conn);
            echo $us; ?></p>
          <a href="allusers.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

  </div>

  <div class="row-center">

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-success text-center">
        <div class="card-body">
          <h5 class="card-title">Người dùng đã phê duyệt</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $au = $adm->acountuser($admc->conn);
            print_r($au); ?></p>
          <a href="aprovedusr.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-warning text-center">
        <div class="card-body">
          <h5 class="card-title">Người dùng chờ phê duyệt</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $pu = $adm->pcountuser($admc->conn);
            echo $pu; ?></p>
          <a href="aprove.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 ">
      <div class="card bg-info text-center">
        <div class="card-body">
          <h5 class="card-title">Tất cả địa điểm</h5>
          <p class="card-text font-weight-bold text-dark h1">
            <?php
            $lc = $adm->countloc($admc->conn);
            echo $lc; ?></p>
          <a href="addlocation.php" class="btn btn-primary green">Chi tiết</a>
        </div>
      </div>
    </div>
  </div>
<?php

} else {
  echo '<h1 class="text-center text-weight-bold text-dark">Bạn không có quyền truy cập</h1>';
}
include('adfoot.php'); ?>