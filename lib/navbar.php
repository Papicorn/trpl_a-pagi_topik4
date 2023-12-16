<header id="header" class="header d-flex align-items-center" style="background-color: #428BFF;">

    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="<?php echo $weburl ?>" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1><?php echo $data_settings['title']; ?><span>.</span></h1>
      </a>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="<?php echo $weburl; ?>">Home</a></li>
          <li><a href="<?php echo $weburl; ?>/#portfolio">Aktivitas</a></li>
          <li><a href="<?php echo $weburl; ?>/berita.php">Berita</a></li>
          <li><a href="<?php echo $weburl; ?>/kegiatan.php">Kegiatan</a></li>
          <li><a href="<?php echo $weburl; ?>/kalender.php">Kalender</a></li>
          <?php 
            if(!isset($_SESSION['email'])) {
          ?>
          <li><a href="<?php echo $weburl; ?>/auth/login.php" class="btn btn-success px-3 py-2">login</a></li>
          <li><a href="<?php echo $weburl; ?>/auth/daftar.php" class="btn btn-primary px-3 py-2">Gabung</a></li>
          <?php }else{ ?>
          <li><a href="<?php echo $weburl; ?>/dashboard/user/index.php" class="btn btn-warning px-3 py-2">Dashboard</a></li>
          <?php } ?>
        </ul>
      </nav><!-- .navbar -->

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->