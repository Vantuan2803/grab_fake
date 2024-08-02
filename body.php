<?php
if (isset($_SESSION['book'])) {
  $p = $_SESSION['book']['pickup'];
  $d = $_SESSION['book']['drop'];
  $c = $_SESSION['book']['cabtype'];
  $l = $_SESSION['book']['lugg'];
}
?>

<body>
  <div id="bg" class="banner pt-2 pb-2">
    <h1 class="text-center font-weight-bold">Cùng chúng tôi có chuyến đi an toàn và tiết kiệm</h1>
    <h5 class="text-center ">Chọn từ một loạt các ưu đãi và quyền lợi</h5>
    <section class="container-fluid box col-lg-4 col-sm-10 col-xs-12 col-md-7 ml-lg-5 ml-md-5 pt-lg-4 mt-lg-4 pt-sm-0 mt-sm-0 mb-5 pb-3 pt-2">
      <div class="text-center">
        <div class="tup1">
          <button class="btn btn-primary green btn-sm tup font-weight-bold">ĐẶT CHUYẾN ĐI</button>
          <hr>
        </div>
        <h4>Cùng chúng tôi có những chuyến đi an toàn</h4>
      </div>
      <form action="" method="post">
        <div class="form-group row feilds">
          <label class="col-sm-3" for="pickup">Điểm xuất phát</label>
          <select class="form-control-plaintext col-sm-9 arro choose" id="pickup">
            <option <?php if (isset($id)) {
                      echo "value=" . $p;
                    } ?> hidden>
              <?php if (isset($p)) {
                echo $p;
              } ?>
            </option>
            <option value="" class="text-secondary" selected disabled hidden>Chọn nơi bạn cần đón</option>
            <?php
            $adm = new adminwrk();
            $admc = new dbcon();
            $show = $adm->fetloc($admc->conn);
            ?>
            <?php foreach ($show as $key => $val) { ?>
              <option value="<?php echo $val['name']; ?>" <?php if (isset($p) && $p == $val['name']) { ?> selected <?php } ?>>
                <?php echo $val['name']; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <!-- <p id="ep" class="bg-danger text-center">Cùng chúng tôi có những chuyến đi an toàn</p> -->
        <div class="form-group row feilds">
          <label class="col-sm-3" for="drop">Điểm đến</label>
          <select class="form-control-plaintext col-sm-9 arro choose" id="drop">
            <option <?php if (isset($id)) {
                      echo "value=" . $d;
                    } ?> hidden>
              <?php if (isset($d)) {
                echo $d;
              } ?>
            </option>
            <option value="" selected disabled hidden>Chọn nơi bạn cần đến</option>
            <?php
            $adm = new adminwrk();
            $admc = new dbcon();
            $show = $adm->fetloc($admc->conn);
            ?>
            <?php foreach ($show as $key => $val) { ?>
              <option value="<?php echo $val['name']; ?>" <?php if (isset($d) && $d == $val['name']) { ?> selected <?php } ?>>
                <?php echo $val['name']; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <p id="ed" class="bg-danger text-center">Chọn điểm đến</p>
        <div class="form-group row feilds">
          <label class="col-sm-3" for="cabtype">Loại xe</label>
          <select class="form-control-plaintext col-sm-9 arro" id="cabtype">
            <option value="" selected disabled hidden>Chọn phương tiện mà bạn muốn di chuyển</option>
            <option <?php if (isset($id)) {
                      echo "value=" . $c;
                    } ?> hidden>
              <?php if (isset($c)) {
                echo $c;
              } ?>
            </option>
            <option value="1" <?php if (isset($c) && $c == '1') { ?> selected <?php } ?>>
              Xe Điện
            </option>
            <option value="2" <?php if (isset($c) && $c == '2') { ?> selected <?php } ?>>
              Xe Máy
            </option>
            <option value="3" <?php if (isset($c) && $c == '3') { ?> selected <?php } ?>>
              Xe oto 4 chỗ
            </option>
            <option value="4" <?php if (isset($c) && $c == '4') { ?> selected <?php } ?>>
              Xe oto 7 chỗ
            </option>
          </select>
        </div>
        <p id="ec" class="bg-danger text-center">Chọn loại xe</p>
        <div class="form-group row feilds">
          <label class="col-sm-3" for="luggage">Hành lý</label>
          <input type="text" class="form-control-plaintext col-sm-9 arrow" maxlength="2" id="lugg" placeholder="Nhập khối lượng hành lý của bạn" <?php if (isset($l)) {
                                                                                                                                                    echo "value=" . $l;
                                                                                                                                                  } ?>>
          <p id="err" class="text-danger h6">Hành lý không có sẵn trên phương tiện này</p>
        </div>
        <p id="nu" class="bg-danger text-center">Nhập khối lượng hành lý của bạn</p>

        <div class="form-group">
          <input type="button" class="btn green btn-primary btn-lg btn-block" id="button4" name="submit" value="Thanh toán" onclick="showPaymentForm()">
        </div>
        <div class="form-group">
          <a class="btn btn-success btn-lg btn-block disabled" id="rbook" name="rbook">Bạn đã đặt xe thành công</a>
          <input type="submit" class="btn green btn-primary btn-lg btn-block" id="book" name="book" value="Hoàn thành">
        </div>
      </form>
    </section>
  </div>

  <!-- Modal thanh toán -->
  <div id="paymentModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Thanh toán</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <h3>Bạn hãy chọn phương thức thanh toán</h3>
          <div class="payment-options">
            <label>
              <input type="radio" name="paymentMethod" value="momo">
              <img src="assets/img/momo.png" alt="Momo" style="width: 50px;">
            </label>
            <label>
              <input type="radio" name="paymentMethod" value="zalopay">
              <img src="assets/img/zalopay.png" alt="ZaloPay" style="width: 50px;">
            </label>
            <label>
              <input type="radio" name="paymentMethod" value="bank">
              <img src="assets/img/bank.png" alt="Bank" style="width: 50px;">
            </label>
          </div>

          <div id="paymentDetails" class="payment-details">
            <p><img id="paymentQRCode" style="width: 150px;" src="assets/img/qr-bank.png" alt="QR Code"></p>
          </div>

          <h4 id="fare" class="green text-center mb-3"></h4>
          <input type="hidden" id="far" name="fare" value="">

          <button type="button" class="btn btn-primary" onclick="completeBooking()">Đã thanh toán</button>
        </div>
      </div>
    </div>
  </div>

  <?php
  if (isset($_SESSION['book'])) {
    unset($_SESSION['book']);
  }
  ?>

  <script>
    document.querySelectorAll('input[name="paymentMethod"]').forEach((input) => {
      input.addEventListener('change', function() {
        const paymentMethod = this.value;
        const qrCodeImage = document.getElementById('paymentQRCode');

        if (paymentMethod === 'momo') {
          qrCodeImage.src = 'assets/img/qr-momo.png';
        } else if (paymentMethod === 'zalopay') {
          qrCodeImage.src = 'assets/img/qr-zalopay.png';
        } else if (paymentMethod === 'bank') {
          qrCodeImage.src = 'assets/img/qr-bank.png';
        }
      });
    });
  </script>

  <script>
    function showPaymentForm() {
      $('#paymentModal').modal('show');
    }

    function completeBooking() {
      $('#paymentModal').modal('hide');
    }
  </script>
</body>