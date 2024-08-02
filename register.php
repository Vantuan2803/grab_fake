<?php
session_start();

if (isset($_SESSION['userdata'])) {
  header("location: index.php");
} else {
  include('user.php');
  $errors = array();
  $message = "";

  if (isset($_POST['submit'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $vehicle_type = isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] : '';
    date_default_timezone_set('asia/kolkata');
    $datetime = date("Y-m-d h:i");

    if ($password != $password2) {
      $errors = "Mật khẩu không khớp";
    }

    $uploadDir = 'assets/img/';
    $licensePath = '';
    $insurancePath = '';
    $registrationPath = '';

    if ($role == 2) {
      $files = ['license', 'insurance', 'registration'];
      foreach ($files as $file) {
        if (isset($_FILES[$file]) && $_FILES[$file]['error'] == 0) {
          $targetDir = $uploadDir . $file . '/';
          if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
          }
          $originalFileName = basename($_FILES[$file]['name']);
          $newFileName = $mobile . '_' . $originalFileName;
          $targetFilePath = $targetDir . $newFileName;

          if (move_uploaded_file($_FILES[$file]['tmp_name'], $targetFilePath)) {
            switch ($file) {
              case 'license':
                $licensePath = $targetFilePath;
                break;
              case 'insurance':
                $insurancePath = $targetFilePath;
                break;
              case 'registration':
                $registrationPath = $targetFilePath;
                break;
              default:
                break;
            }
          } else {
            echo '<p class="bg-danger text-center">Lỗi khi tải lên file</p>';
          }
        } else {
          echo '<p class="bg-danger text-center">File không tồn tại hoặc có lỗi.</p>';
        }
      }
    }
    $user = new user();
    $dbcon = new dbcon();
    $show = $user->register($username, $password, $password2, $email, $mobile, $datetime, $role, $vehicle_type, $licensePath, $insurancePath, $registrationPath, $dbcon->conn);
  }
  include('header.php');
  include('navh.php');
?>

  <body>
    <style>
      .file-input {
        border: 1px solid white;
        padding: 10px;
      }

      .file-input::-webkit-file-upload-button {
        visibility: hidden;
      }

      .file-input::before {
        content: "Chọn ảnh";
        display: inline-block;
        border: 1px solid #999;
        border-radius: 3px;
        padding: 5px 8px;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        cursor: pointer;
        font-weight: 700;
        font-size: 10pt;
      }
    </style>
    <div id="bg" class="banner pt-2 pb-2">
      <h1 class="text-center mt-lg-5 font-weight-bold">Trải nghiệm cùng Grab Fake</span></h1>
      <section class="container-fluid box col-lg-10 col-sm-10 col-xs-12 col-md-7  pt-lg-4 mt-lg-4 pt-sm-0 mt-sm-0 mb-5 pb-3 pt-2">
        <div class="text-center">
          <h4 class="font-weight-bold">Đăng ký tài khoản</h4>
        </div>
        <form action="register.php" method="post" enctype="multipart/form-data">

          <div class="form-group  row feilds ">
            <label class="col-sm-2">Họ và tên</label>
            <input name="username" for="username" type="text" class="form-control-plaintext col-sm-10 arro" id="username" placeholder="Nhập họ và tên" required>
          </div>

          <div class="form-group  row feilds ">
            <label class="col-sm-2">Email</label>
            <input name="email" for="email" type="email" class="form-control-plaintext col-sm-10 arro" id="email" placeholder="Nhập email của bạn" required>
          </div>

          <div class="form-group  row feilds ">
            <label class="col-sm-2" for="password">Mật khẩu</label>
            <input type="password" name="password" class="form-control-plaintext col-sm-10 arro" id="password" placeholder="Nhập mật khẩu" required>
          </div>

          <div class="form-group  row feilds ">
            <label class="col-sm-2" for="password2">Xác nhận mật khẩu</label>
            <input type="password" name="password2" class="form-control-plaintext col-sm-10 arro" id="password2" placeholder="Nhập lại mật khẩu" required>

          </div>
          <p id="pas" class="bg-danger text-center">Mật khẩu phải giống nhau</p>

          <div class="form-group  row feilds ">
            <label class="col-sm-2">Số điện thoại</label>
            <input name="mobile" for="mobile" type="text" class="form-control-plaintext col-sm-10 arro" maxlength="10" minlength="10" id="mobile" placeholder="Nhập số điện thoại" required>
          </div>

          <div class="form-group  row feilds ">
            <label class="col-sm-2">Tôi là</label>
            <select name="role" id="role" class="col-sm-10">
              <option value="3" selected>Người dùng</option>
              <option value="2">Tài xế</option>
            </select>
          </div>

          <div id="additionalInput" style="display: none;">
            <div class="form-group row feilds ">
              <label class="col-sm-3">Loại xe</label>
              <select name="vehicle_type" class="form-control-select col-sm-9" required>
                <option value="0">Chọn loại xe</option>
                <option value="1">Xe Điện</option>
                <option value="2">Xe Máy</option>
                <option value="3">Xe oto 4 chỗ</option>
                <option value="4">Xe oto 7 chỗ</option>
              </select>
            </div>
            <div class="form-group  row feilds ">
              <label class="col-sm-3">Bằng lái xe</label>
              <input type="file" name="license" class="form-control-file col-sm-9 file-input">
            </div>
            <div class="form-group  row feilds ">
              <label class="col-sm-3">Giấy đăng ký xe</label>
              <input type="file" name="insurance" class="form-control-file col-sm-9 file-input">
            </div>
            <div class="form-group  row feilds ">
              <label class="col-sm-3">Bảo hiểm phương tiện</label>
              <input type="file" name="registration" class="form-control-file col-sm-9 file-input">
            </div>
          </div>

          <div class="form-group ">
            <input type="submit" class="btn green btn-primary btn-lg btn-block" id="register" name="submit" value="Đăng ký">
          </div>
        </form>
        <script>
          document.getElementById('role').addEventListener('change', function() {
            var value = this.value;
            if (value == '2') {
              document.getElementById('additionalInput').style.display = '';
            } else {
              document.getElementById('additionalInput').style.display = 'none';
            }
          });
        </script>
      </section>
    </div>
  <?php include('footer.php');
}
  ?>