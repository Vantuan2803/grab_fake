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
    include('header.php');
    include('user.php');
    include('navs.php');
    if ($_SESSION['userdata']['role'] != 1) {
        include('ussidebar.php');
        $id = $_GET['id'];
        $adm = new user();
        $admc = new dbcon();
        $shor = $adm->iallride($id, $admc->conn);
        foreach ($shor as $key => $val) {
            $rid = $val['ride_id'];
            $cid = $val['customer_user_id'];
            $date = $val['ride_date'];
            $cab = $val['cab_type'];
            $pic = $val['from_distance'];
            $drop = $val['to_distance'];
            $lugg = $val['luggage'];
            $fare = $val['total_fare'];
            $dist = $val['total_distance'];
        }
        $usr = $adm->ialluser($cid, $admc->conn);
        foreach ($usr as $key1 => $val1) {
            $name = $val1['name'];
            $email = $val1['user_name'];
            $mob = $val1['mobile'];
        }
    ?>

        </head>

        <body>
            <div id="pbox">
                <div class="invoice-box">
                    <table cellpadding="0" cellspacing="0">
                        <tr class="top">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td class="title">
                                            <a style="width:100%; max-width:300px;">Grab<span class="logo-header">Fake</span>
                                        </td>
                                        <td>
                                            Mã chuyến đi : <?php echo $rid; ?><br>
                                            Thời gian đặt &#9660; : <?php echo $date; ?><br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr class="information">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td>
                                            Tên khách hàng :<br>
                                            Email :<br>
                                            Số điện thoại :
                                        </td>
                                        <td>
                                            <?php echo $name; ?><br>
                                            <?php echo $email; ?><br>
                                            <?php echo $mob; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr class="heading">
                            <td>
                                Loại xe
                            </td>
                            <td>
                                <?php echo $cab; ?>
                            </td>
                        </tr>

                        <tr class="details">
                            <td>
                                Quãng đường &#9660;
                            </td>
                            <td>
                                <?php echo $dist; ?> Km
                            </td>
                        </tr>

                        <tr class="item">
                            <td>
                                Điểm xuất phát
                            </td>
                            <td>
                                <?php echo $pic; ?>
                            </td>
                        </tr>

                        <tr class="item">
                            <td>
                                Điểm đến
                            </td>
                            <td>
                                <?php echo $drop; ?>
                            </td>
                        </tr>

                        <tr class="item last">
                            <td>
                                Hành lý
                            </td>
                            <td>
                                <?php echo $lugg; ?> Kg
                            </td>
                        </tr>

                        <tr class="total">
                            <td>Thanh toán</td>
                            <td>VNĐ
                                <?php echo $fare; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="text-center mt-3 mr-lg-5 pr-lg-5">
                <button id="prnt">Xuất hóa đơn</button>
            </div>
    <?php
    }
    include('adfoot.php');
} ?>