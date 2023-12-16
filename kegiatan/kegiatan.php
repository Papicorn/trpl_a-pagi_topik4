<?php 
session_start();
require '../koneksi.php';
require '../config.php';

$cek_settings = mysqli_query($koneksi, "SELECT * FROM settings");
$data_settings = mysqli_fetch_assoc($cek_settings);

if (!isset($_GET['id_kegiatan'])) {
    header('Location:' . $weburl);
} else {
    $email = $_SESSION['email'];
    $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email' OR username ='$email'");
    $data_user = mysqli_fetch_assoc($cek_user);
    $id_user = $data_user['id_user'];
            
    $id_kegiatan = $_GET['id_kegiatan'];
    $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
    $data_kegiatan = mysqli_fetch_assoc($cek_kegiatan);
    $id_komunitas = $data_kegiatan['id_community'];
    $nama_kegiatan1 = $data_kegiatan['judul_kegiatan'];
    
    $mulai = $data_kegiatan['tgl_mulai'] . " " . $data_kegiatan['waktu_mulai'];
    $selesai = $data_kegiatan['tgl_selesai'] . " " . $data_kegiatan['waktu_selesai'];
    $today = $tanggal . " " . $time;
    
    $cek_komunitas = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_komunitas'");
    $data_komunitas = mysqli_fetch_assoc($cek_komunitas);
    
    if(isset($_POST['gabung'])) {
        if (!isset($_SESSION['email'])){
            header('Location: '.$weburl.'/auth/login.php');
        } else {
            $cek_gk = mysqli_query($koneksi, "SELECT * FROM gabung_kegiatan WHERE id_user = '$id_user' AND id_kegiatan = '$id_kegiatan'");
            
            if(strtotime($selesai) < strtotime($today)) {
                $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Kegiatan ini sudah berakhir', 'pesan' => 'Gagal');
            } else {
                if($data_user['level'] == "user") {
                    if(mysqli_num_rows($cek_gk) != 0) {
                        $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Anda sudah tergabung pada kegiatan ini', 'pesan' => 'Gagal');
                    } else {
                        if (mysqli_query($koneksi, "INSERT INTO gabung_kegiatan VALUES ('','$id_user', '$id_kegiatan', '$today')") == TRUE && mysqli_query($koneksi, "INSERT INTO aktivitas VALUES ('', 'Bergabung pada kegiatan $nama_kegiatan1', '$id_user', '$today')") == TRUE) {
                            echo '<audio autoplay="true" style="display:none;">
                                <source src="'. $weburl .'/assets/sound/success.mp3" type="audio/mp3">
                            </audio>';
                            $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil bergabung pada kegiatan', 'pesan' => 'Berhasil');
                        } else {
                            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat memasukan data, hubungi CS!', 'pesan' => 'Gagal');
                        }
                    }
                } else {
                    $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Anda adalah tidak dapat bergabung kegiatan, karena anda login sebagai akun admin!', 'pesan' => 'Berhasil');
                }
            }
        }
    } else if (isset($_POST['submit'])) {
                $ulasan = mysqli_real_escape_string($koneksi, $_POST['ulasan']);
                
                $today = $tanggal . " " . $time;
                
                if (mysqli_query($koneksi, "INSERT INTO ulasan  VALUES ('','$id_user','$ulasan','$id_kegiatan','$today')") == TRUE && mysqli_query($koneksi, "INSERT INTO aktivitas VALUES ('', 'Memberikan ulasan pada kegiatan $nama_kegiatan1', '$id_user', '$today')") == TRUE) {
                    $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil menambahkan ulasan', 'pesan' => 'Berhasil');
                } else {
                    $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat memasukkan data anda', 'pesan' => 'Gagal');
                }
        }
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $data_kegiatan['judul_kegiatan']; ?> - <?php echo $data_settings['title']; ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">
  

  <!-- =======================================================
  * Template Name: Impact
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/impact-bootstrap-business-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
    <?php require '../lib/navbar.php'; ?>
  <!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <nav>
        <div class="container">
          <ol>
            <li><a href="<?php echo $weburl; ?>">Home</a></li>
            <li><?php echo $data_kegiatan['judul_kegiatan']; ?></li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details pt-3">
      <div class="container" data-aos="fade-up">
            <?php  
                if(isset($_SESSION['alert'])) {
            ?>
            <div class="alert alert-<?php echo $_SESSION['alert']['alert']; ?> alert-dismissible fade show" role="alert">
              <?php echo $_SESSION['alert']['judul']; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
                unset($_SESSION['alert']);
            } ?>
            
            <script>
                var alertList = document.querySelectorAll('.alert')
                alertList.forEach(function (alert) {
                  new bootstrap.Alert(alert)
                })
            </script>
        
        <div class="row justify-content-between gy-4">
            <div class="col-lg-8">
                <div class="row justify-content-between gy-4">
                    <div class="col-lg-12">
                        <p class="text-muted mb-1" style="font-size: 14px;">Waktu kegiatan dibuat <?php echo $data_kegiatan['tgl_dibuat']; ?></p>
                        <div class="position-relative">
                            <img src="../assets/img/kegiatan/<?php echo $data_kegiatan['banner']; ?>" class="img-fluid" alt="Responsive image">
                        </div>
                    </div>
                    
        
                    <div class="col-lg-12">
                        <div class="portfolio-description">
                          <h2><?php echo $data_kegiatan['judul_kegiatan']; ?></h2>
                          <?php echo $data_kegiatan['isi_kegiatan']; ?>
            
                        </div>
                    </div>
                </div>
        </div>
          
          <div class="col-lg-3">
              <div class="row justify-content-between gy-4">
                  <div class="col-lg-12">
                    <div class="portfolio-info">
                      <h3>Informasi Kegiatan</h3>
                      <form method="POST">
                          <ul>
                            <li><strong>Kategori</strong> <span><?php echo $data_kegiatan['kategori']; ?></span></li>
                            <li><strong>Komunitas</strong> <span><?php echo $data_komunitas['nama_komunitas']; ?></span></li>
                            <li><strong>Waktu Mulai</strong> <span><?php echo $data_kegiatan['tgl_mulai'] . " " . $data_kegiatan['waktu_mulai']; ?></span></li>
                            <li><strong>Waktu Selesai</strong> <span><?php echo $data_kegiatan['tgl_selesai'] . " " . $data_kegiatan['waktu_selesai']; ?></span></li>
                            <li><strong>Lokasi</strong> <span><?php echo $data_kegiatan['lokasi']; ?></span></li>
                            <?php 
                                if (strtotime($selesai) < strtotime($today)) {
                                    $text = "Sudah Berakhir";
                                    $status = "disabled";
                                    $bg = "danger";
                                } elseif (strtotime($today) > strtotime($mulai) && strtotime($today) < strtotime($selesai)) {
                                    $text = "Sedang Berlangsung";
                                    $status = "disabled";
                                    $bg = "warning";
                                } else {
                                    $text = "Bergabung Kegiatan";
                                    $status = "";
                                    $bg = "success";
                                }
                            ?>
                            <li><button type="submit" name="gabung" class="btn-visit align-self-start border-0 bg-<?php echo $bg; ?>" <?php echo $status; ?>> <?php echo $text; ?></button></li>
                          </ul>
                      </form>
                    </div>
                  </div>
            </div>
          </div>
          
          </div>
          <div class="row justify-content-between gy-4 mt-4">
              <div class="col-lg-8 mt-4">
                  <hr class="border-2">
                  <div class="portfolio-info mb-5">
                      <div class="comments">
                      <?php  
                        $cek_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan WHERE id_kegiatan = '$id_kegiatan' ORDER BY tgl_ulasan DESC");
                        $jumlah_ulasan = mysqli_num_rows($cek_ulasan);
                      ?>
                      <h3><?php echo $jumlah_ulasan; ?> Ulasan</h3>
                      <?php 
                      if ($jumlah_ulasan > 0) {
                        while ($data_ulasan = mysqli_fetch_assoc($cek_ulasan)) {
                            $id_user = $data_ulasan['id_user'];
                            $cek_user1 = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
                            $data_user1 = mysqli_fetch_assoc($cek_user1);
                      ?>
                      
                      <div id="comment-1" class="comment mb-3">
                        <div class="d-flex">
                          <div class="comment-img"><img src="../assets/img/profile.jpg" alt="" style="width: 60px; margin-right: 10px;" class="rounded-circle"></div>
                          <div class="ml-2">
                            <p class="fw-bold m-0"><?php echo $data_user1['username']; ?></p>
                            <time class="text-muted" style="font-size: 14px;"><?php echo $data_ulasan['tgl_ulasan']; ?></time>
                            <p>
                              <?php echo $data_ulasan['ulasan']; ?>
                            </p>
                          </div>
                        </div>
                      </div><!-- End comment #1 -->
                      <?php }} ?>
                      </div>
                      
                  </div>
                  <?php 
                    $data_gk = mysqli_query($koneksi, "SELECT * FROM gabung_kegiatan WHERE id_kegiatan = '$id_kegiatan' AND id_user = '$id_user'");
                    if(mysqli_num_rows($data_gk) != 0 && strtotime($selesai) < strtotime($today)) {
                  ?>
                  <div class="card bg-light ">
                    <div class="card-body">
                <h4>Berikan Ulasan</h4>
                <p>Alamat email anda tidak akan di publikasikan. Kolom yang harus diisi ditandai *</p>
                <form method="POST">
                  <div class="row mb-2">
                    <div class="col form-group">
                      <textarea name="ulasan" class="form-control" placeholder="Ulasan anda*" required></textarea>
                    </div>
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary">Posting Ulasan</button>

                </form>
                </div>

              </div>
              <?php } else {} ?>
              </div>
          </div>
            

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>
  <?php require '../lib/footer.php'; ?>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>