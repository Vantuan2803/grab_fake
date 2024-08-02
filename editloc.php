<?php
include('adhead.php');
if (!isset($_SESSION['userdata'])) {
  header('Location: index.php');
}
if ($_SESSION['userdata']['role'] == 1) {
  include('adsidebar.php');

  if (isset($_POST['edit'])) {
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $distance = isset($_POST['distance']) ? $_POST['distance'] : '';
    $available = isset($_POST['available']) ? $_POST['available'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $adm = new adminwrk();
    $admc = new dbcon();
    $show = $adm->elocation($location, $distance, $available, $id, $admc->conn);
  }
  if (isset($_GET['id'])) {
    $na = $_GET['name'];
    $di = $_GET['distance'];
    $ava = $_GET['is_available'];
    $d = $_GET['id'];
  }
?>

  <nav class="nav nav-pills nav-justified col-sm-10">
    <a class="nav-link btn-light" href="addlocation.php">Tất cả địa điểm</a>
    <a class="nav-link btn-light" href="locat.php">Thêm địa điểm</a>
    <a class="nav-link btn-light active" href="editloc.php">Sửa địa điểm</a>
  </nav>

  <div>
    <h3 class="text-center">Cập nhật thông tin</h3>
    <section class="container-fluid box col-lg-7 col-sm-10 col-xs-12 col-md-7  pt-lg-4 mt-lg-4 pt-sm-0 mt-sm-0 mb-5 pb-3 pt-2">
      <form action="editloc.php" method="post">
        <div class="form-group row feilds ">
          <label class="col-sm-2" for="location">Tên địa điểm</label>
          <input class="form-control-plaintext col-sm-10 " type="text" name="location" id="location" pattern="^[a-zA-Z_]+( [a-zA-Z0-9_]+)*$" placeholder="Nhập địa điểm" value="<?php if (isset($na)) {
                                                                                                                                                                                  echo $na;
                                                                                                                                                                                } ?>" required>
        </div>
        <div class="form-group  row feilds ">
          <label class="col-sm-2" for="distance">Quãng đường</label>
          <input class="form-control-plaintext col-sm-10 " type="number" name="distance" id="distance" step=".01" placeholder="Nhập quãng đường" <?php if (isset($di)) {
                                                                                                                                                    echo "value=" . $di;
                                                                                                                                                  } ?> required>
        </div>
        <div class="form-group feilds ">
          <label for="available">Chọn trạng thái</label>
          <label for="yes">Có</label>
          <input class="" type="radio" name="available" id="available" value=1 <?php if (isset($ava)) {
                                                                                  echo ($ava == 1) ?  "checked" : "";
                                                                                } ?> required>
          <label for="no">Không</label>
          <input class="" type="radio" name="available" id="available" value=0 <?php if (isset($ava)) {
                                                                                  echo ($ava == 0) ?  "checked" : "";
                                                                                } ?> required>
        </div>
        <input type="hidden" name="id" id="id" <?php if (isset($d)) {
                                                  echo "value= " . $d;
                                                } ?>>
        <div class="form-group ">
          <input type="submit" class="btn green btn-primary btn-lg btn-block" id="edit" name="edit" value="Hoàn thành">
        </div>
      </form>
    </section>
  </div>
<?php

} else {
  echo '<h1 class="text-center text-weight-bold text-dark">Bạn không có quyền truy cập</h1>';
}
include('adfoot.php'); ?>