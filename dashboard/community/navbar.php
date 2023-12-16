<nav class="main-header p-2 navbar-dark d-lg-none d-block" style="background-color: #3c80f0 !important;">
    <!-- Left navbar links -->
    <div class="d-flex justify-content-between">
        <div class="dropdown">
          <a class="nav-link" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars text-light" style="font-size: 25px;"></i></a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?= $weburl; ?>/dashboard/community/index.php">Dashboard</a>
            <a class="dropdown-item" href="<?= $weburl; ?>/dashboard/community/sidebar/kegiatan.php">Kegiatan</a>
            <a class="dropdown-item" href="<?= $weburl ?>/dashboard/community/sidebar/komunitas.php">Kelola Komunitas</a>
            <a class="dropdown-item" href="<?= $weburl ?>/dashboard/community/sidebar/anggota.php">Anggota</a>
            <a class="dropdown-item" href="<?= $weburl ?>/auth/logout.php">Logout</a>
          </div>
        </div>
        <div>
            <a href="<?= $weburl ?>"><img src="<?= $weburl ?>/assets/image/kitapeduli.png" style="width:160px;"></a>
        </div>
            <div class="user-panel">
                <div class="image px-2">
                  <img src="<?= $weburl ?>/assets/dist/img/user2-160x160.jpg" class="img-circle" style="width: 50px;" alt="User Image">
                </div>
          </div>
    </div>
  </nav>