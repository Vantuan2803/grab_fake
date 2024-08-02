<div class="sidebar col-lg-2 bg-info container-fluid float-left">
  <a href="dash.php">Hoạt động</a>
  <a href="<?php echo $_SESSION['userdata']['role'] == 2? 'upenride.php' : 'usrride.php' ?>">Chuyến đi</a>
  <a href="usrprofile.php">Thông tin cá nhân</a>
</div>