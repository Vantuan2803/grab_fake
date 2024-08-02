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
      <a class="navbar-brand nos" href="#">Ced<span class="logo-header">Cab</span></a>
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
  if (isset($_POST['change'])) {
    $old = isset($_POST['old']) ? $_POST['old'] : '';
    $new = isset($_POST['new']) ? $_POST['new'] : '';
    $rnew = isset($_POST['rnew']) ? $_POST['rnew'] : '';
    $idp = isset($_POST['id']) ? $_POST['id'] : '';

    $adm = new user();
    $admc = new dbcon();
    $show = $adm->changep($old, $new, $rnew, $idp, $admc->conn);
  }

  $id = $_SESSION['userdata']['user_id'];
  $adm = new user();
  $admc = new dbcon();
  $show = $adm->prof($id, $admc->conn);
  $na = '';
  $mo = '';
  $vehicle_type = '';
  $licensePath = '';
  $insurancePath = '';
  $registrationPath = '';
  $documents_id = '';
  foreach ($show as $key => $val) {
    $na = $val['name'];
    $mo = $val['mobile'];
    $vehicle_type = $val['vehicle_type'];
  }

  $images = $adm->getImages($mo, $admc->conn);
  foreach ($images as $key => $val) {
    $documents_id = $val['id'];
    $licensePath = $val['license'];
    $insurancePath = $val['insurance'];
    $registrationPath = $val['registration'];
  }

  if (isset($_POST['edit'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $vehicle_type = isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] : '';
    $ida = isset($_POST['id']) ? $_POST['id'] : '';

    function uploadFiles($filesInfo, $mobile)
    {
      $folders = ['license', 'insurance', 'registration'];
      $paths = [];

      foreach ($folders as $folder) {
        $oldFile = $filesInfo[$folder]['oldPath'];
        if (isset($_FILES[$folder]) && $_FILES[$folder]['error'] == 0) {
          $uploadDir = "assets/img/" . $folder . "/" . $mobile . '_';

          if (is_file($oldFile)) {
            unlink($oldFile);
          }

          $targetFilePath = $uploadDir . basename($_FILES[$folder]["name"]);
          if (move_uploaded_file($_FILES[$folder]['tmp_name'], $targetFilePath)) {
            $paths[$folder] = $targetFilePath;
          } else {
            echo '<p class="bg-danger text-center text-white">Lỗi khi tải lên file ' . $folder . '</p>';
          }
        } else {
          $paths[$folder] = $oldFile;
        }
      }

      return $paths;
    }

    $filesInfo = [
      'license' => ['oldPath' => $licensePath],
      'insurance' => ['oldPath' => $insurancePath],
      'registration' => ['oldPath' => $registrationPath]
    ];

    $paths = uploadFiles($filesInfo, $mobile);

    $newlicensePath = $paths['license'] ?? '';
    $newinsurancePath = $paths['insurance'] ?? '';
    $newregistrationPath = $paths['registration'] ?? '';

    $adm = new user();
    $admc = new dbcon();
    $show = $adm->uprof($name, $mobile, $vehicle_type, $documents_id, $newlicensePath, $newinsurancePath, $newregistrationPath, $ida, $admc->conn);
  }
  include('header.php');
  include('navs.php');
  include('ussidebar.php');
?>

  <nav class="nav nav-pills nav-justified col-sm-10">
    <button class="nav-link btn btn-light " id="edipr">Thông tin cá nhân</button>
    <button class="nav-link btn btn-light " id="chpa">Đổi mật khẩu</button>
  </nav>

  <div class="center" id="edi">
    <section class="container-fluid box col-lg-10 col-sm-10 col-xs-12 col-md-10  pt-lg-4 mt-lg-4 pt-sm-0 mt-sm-0 mb-5 pb-3 pt-2" style="width: 60%;">
      <h3 class="text-center">Thông tin cá nhân</h3>
      <form action="usrprofile.php" method="post" enctype="multipart/form-data">
        <div class="form-group  row feilds ">
          <label class="col-sm-3" for="name">Họ và tên</label>
          <input class="form-control-plaintext col-sm-9" type="text" name="name" id="name" placeholder="Nhập họ và tên" value="<?php if (isset($na)) {
                                                                                                                                                                      echo $na;
                                                                                                                                                                    } ?>" required>
        </div>
        <div class="form-group  row feilds ">
          <label class="col-sm-3" for="mobile">Số điện thoại</label>
          <input class="form-control-plaintext col-sm-9" type="text" name="mobile" id="mobile" maxlength="10" minlength="10" placeholder="Nhập số điện thoại" <?php if (isset($mo)) {
                                                                                                                                                                echo "value=" . $mo;
                                                                                                                                                              } ?> required>
        </div>
        <?php if ($_SESSION['userdata']['role'] == 2) : ?>
          <div class="form-group row feilds ">
            <label class="col-sm-3" for="vehicle_type">Loại xe</label>
            <select class="form-control-select col-sm-9" name="vehicle_type" id="vehicle_type">
              <?php
              $sql = "SELECT * FROM vehicle";
              $result = $admc->conn->query($sql);
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $type = $row['id'];
                  $vehicle_name = $row['name'];
                  echo "<option value='$type' ";
                  if (isset($vehicle_type) && $vehicle_type == $type) {
                    echo "selected";
                  }
                  echo ">$vehicle_name</option>";
                }
              }
              ?>
            </select>
          </div>
          <div class="row feilds ">
            <div class="col-sm-4">
              <div>
                <img src="<?php if (isset($licensePath)) {
                            echo $licensePath;
                          } ?>" alt="License" class="img-thumbnail">
                <p class="text-center">Giấy phép lái xe</p>
              </div>
              <div class="form-group">
                <input type="file" name="license" class="form-control-file">
              </div>
            </div>
            <div class="col-sm-4">
              <div>
                <img src="<?php if (isset($insurancePath)) {
                            echo $insurancePath;
                          } ?>" alt="Insurance" class="img-thumbnail">
                <p class="text-center">Bảo hiểm xe</p>
              </div>
              <div class="form-group">
                <input type="file" name="insurance" class="form-control-file">
              </div>
            </div>
            <div class="col-sm-4">
              <div>
                <img src="<?php if (isset($registrationPath)) {
                            echo $registrationPath;
                          } ?>" alt="Registration" class="img-thumbnail">
                <p class="text-center">Đăng ký xe</p>
              </div>
              <div class="form-group">
                <input type="file" name="registration" class="form-control-file">
              </div>
            </div>
          </div>
        <?php endif; ?>
        <input type="hidden" name="id" id="id" <?php if (isset($id)) {
                                                  echo "value= " . $id;
                                                } ?>>
        <div class="form-group ">
          <input type="submit" class="btn green btn-primary btn-lg btn-block" id="edit" name="edit" value="Lưu thay đổi">
        </div>
      </form>
    </section>
  </div>

  <div class="center" id="cpaa">
    <h3 class="text-center">Đổi mật khẩu</h3>
    <section class="container-fluid box col-lg-7 col-sm-10 col-xs-12 col-md-7  pt-lg-4 mt-lg-4 pt-sm-0 mt-sm-0 mb-5 pb-3 pt-2">
      <form action="usrprofile.php" method="post">
        <div class="form-group  row feilds ">
          <label class="col-sm-4" for="old">Mật khẩu cũ</label>
          <input class="form-control-plaintext col-sm-8 " type="password" name="old" id="old" placeholder="******" required>
        </div>

        <div class="form-group  row feilds ">
          <label class="col-sm-4" for="new">Mật khẩu mới</label>
          <input class="form-control-plaintext col-sm-8 " type="password" name="new" id="new" placeholder="******" required>
        </div>

        <div class="form-group  row feilds ">
          <label class="col-sm-4" for="rnew">Xác nhận mật khẩu mới</label>
          <input class="form-control-plaintext col-sm-8 " type="password" name="rnew" id="rnew" placeholder="******" required>
        </div>

        <input type="hidden" name="id" id="id" <?php if (isset($id)) {
                                                  echo "value= " . $id;
                                                } ?>>
        <div class="form-group ">
          <input type="submit" class="btn green btn-primary btn-lg btn-block" id="change" name="change" value="Đổi mật khẩu">
        </div>
      </form>
    </section>
  </div>

<?php include('adfoot.php');
} ?>