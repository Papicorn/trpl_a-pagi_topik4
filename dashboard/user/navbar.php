<nav class="main-header p-2 navbar-dark d-lg-none d-block" style="background-color: #3c80f0 !important;">
    <!-- Left navbar links -->
    <div class="d-flex justify-content-between">
        <div class="dropdown">
          <a class="nav-link" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars text-light" style="font-size: 25px;"></i></a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?= $weburl; ?>/dashboard/user/index.php">Dashboard</a>
            <a class="dropdown-item" href="<?= $weburl; ?>/dashboard/user/sidebar/kegiatan.php">Kegiatan</a>
            <a class="dropdown-item" href="<?= $weburl; ?>/dashboard/user/sidebar/berita.php">Berita</a>
            <a class="dropdown-item" href="<?= $weburl ?>/dashboard/user/sidebar/komunitas.php">Komunitas</a>
            <a class="dropdown-item" href="<?= $weburl ?>/dashboard/user/sidebar/pengaturan-profile.php">Pengaturan Profile</a>
            <a class="dropdown-item" href="<?= $weburl ?>/auth/logout.php">Logout</a>
          </div>
        </div>
        <div>
            <a href="<?= $weburl ?>"><img src="<?= $weburl ?>/assets/image/kitapeduli.png" style="width:175px;"></a>
        </div>
            <div class="user-panel">
            <div class="image px-2">
              <img src="<?= $weburl ?>/assets/dist/img/user2-160x160.jpg" class="img-circle" style="width: 40px;" alt="User Image">
            </div>
          </div>
    </div>
  </nav>