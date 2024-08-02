<header>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand nos" href="indexlog.php">Grab<span class="logo-header">Fake</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span><i class="fas fa-bars logo text-dark"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-5">
                    <p class="">Chào mừng <?php echo $_SESSION['userdata']['username'] ?></p>
                </li>
                <li class="nav-item rbtn">
                    <a class="btn" href="dash.php">Hoạt động</a>
                </li>
                <?php if ($_SESSION['userdata']['role'] == 3) { ?>
                    <li class="nav-item rbtn">
                        <a class="btn" href="indexlog.php">Đặt xe ngay</a>
                    </li>
                <?php } ?>
                <li class="nav-item rbtn">
                    <a class="btn" href="logout.php">Đăng xuất</a>
                </li>
            </ul>
        </div>

    </nav>
</header>