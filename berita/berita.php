<?php 
    session_start();
    require '../koneksi.php';
    require '../config.php';
    
    $cek_settings = mysqli_query($koneksi, "SELECT * FROM settings");
    $data_settings = mysqli_fetch_assoc($cek_settings);
    
    if (!isset($_GET['id_news'])) {
        header('Location:' . $weburl);
    } else {
        $id_news = $_GET['id_news'];
        $cek_news = mysqli_query($koneksi, "SELECT * FROM news WHERE id_news = '$id_news'");
        $data_news = mysqli_fetch_assoc($cek_news);
        $id_user = $data_news['id_user'];
        
        $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
        $usernya = mysqli_fetch_assoc($cek_user);
        
        $cek_komentar = mysqli_query($koneksi, "SELECT * FROM komentar WHERE id_news = '$id_news' ORDER BY tgl_komentar DESC");
        $jumlah_komentar = mysqli_num_rows($cek_komentar);
        
        $tgl_dibuat = $data_news['tgl_dibuat'];
        $tanggal_buat = date('M d, Y', strtotime($tgl_dibuat));
        
        if (isset($_POST['submit'])) {
            if (!isset($_SESSION['email'])) {
                header('Location: '.$weburl.'/auth/login.php');
            } else {
                $comment = mysqli_real_escape_string($koneksi, $_POST['comment']);
                $email = $_SESSION['email'];
                $cek_user2 = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email' OR username ='$email'");
                $data_user2 = mysqli_fetch_assoc($cek_user2);
                $id_user = $data_user2['id_user'];
                
                $today = $tanggal . " " . $time;
                
                $jodul = $data_news['judul'];
                
                if (mysqli_query($koneksi, "INSERT INTO komentar VALUES ('', '$id_user', '$id_news', '$comment', '$today')") == TRUE && mysqli_query($koneksi, "INSERT INTO aktivitas VALUES ('', 'Memberikan komentar pada berita $jodul', '$id_user', '$today')") == TRUE) {
                    $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil menambahkan komentar', 'pesan' => 'Berhasil');
                } else {
                    $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat memasukkan data anda', 'pesan' => 'Gagal');
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $data_news['judul']; ?> - <?php echo $data_settings['title']; ?></title>
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

    

    <!-- ======= Blog Details Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row g-5">

          <div class="col-lg-8 mt-1">
                <?php  
                    if(isset($_SESSION['alert'])) {
                ?>
                <div class="alert alert-<?php echo $_SESSION['alert']['alert']; ?> alert-dismissible fade show" role="alert">
                  <?php echo $_SESSION['alert']['judul']; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php 
                    unset($_SESSION['alert']);
                    header('Refresh: 2;');
                } ?>
                
                <script>
                    var alertList = document.querySelectorAll('.alert')
                    alertList.forEach(function (alert) {
                      new bootstrap.Alert(alert)
                    })
                </script>
            <p class="text-muted mb-1" style="font-size: 14px;">Terakhir diupdate <?php echo $data_news['tgl_dibuat']; ?></p>
            <article class="blog-details">

              <div class="post-img">
                <img src="../assets/img/news/<?php echo $data_news['banner']; ?>" alt="" class="img-fluid" style="width: 100%;">
              </div>

              <h2 class="title"><?php echo $data_news['judul']; ?></h2>

              <div class="meta-top">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <?php echo $usernya['username']; ?></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <time><?php echo $tanggal_buat; ?></time></li>
                  <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <?php echo $jumlah_komentar; ?> Komentar</li>
                </ul>
              </div><!-- End meta top -->

              <div class="content">
                <?php echo $data_news['isi_news']; ?>
              </div><!-- End post content -->

              <div class="meta-bottom">
                <i class="bi bi-tags"></i>
                <ul class="tags">
                  <li><a href="#"><?php echo $data_news['kategori']; ?></a></li>
                </ul>
              </div><!-- End meta bottom -->

            </article><!-- End blog post -->

            <div class="comments">

              <h4 class="comments-count"><?php echo $jumlah_komentar ?> Komentar</h4>
              
              <?php 
                
                while ($row = mysqli_fetch_assoc($cek_komentar)) {
                    $id_user1 = $row['id_user'];
                    $cek_user1 = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user1'");
                    $data_user1 = mysqli_fetch_assoc($cek_user1);
              ?>

              <div id="comment-1" class="comment">
                <div class="d-flex">
                  <div class="comment-img"><img src="../assets/img/profile.jpg" alt="" class="rounded-circle"></div>
                  <div>
                    <h5><a href=""><?php echo $data_user1['username']; ?></a></h5>
                    <time datetime="2020-01-01"><?php echo $row['tgl_komentar']; ?></time>
                    <p>
                      <?php echo htmlspecialchars($row['komentar']); ?>
                    </p>
                  </div>
                </div>
              </div><!-- End comment #1 -->
              
              <?php 
                }
              ?>

              <div class="reply-form">

                <h4>Berikan Komentar</h4>
                <p>Alamat email anda tidak akan di publikasikan. Kolom yang harus diisi ditandai *</p>
                <form method="POST">
                  <div class="row">
                    <div class="col form-group">
                      <textarea name="comment" class="form-control" placeholder="Your Comment*" required></textarea>
                    </div>
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary">Posting Komentar</button>

                </form>

              </div>

            </div><!-- End blog comments -->

          </div>

          <div class="col-lg-4">

            <div class="sidebar">

              <div class="sidebar-item recent-posts">
                <h3 class="sidebar-title">Postingan Terbaru</h3>

                <div class="mt-3">

                    <?php  
                        $cek_news1 = mysqli_query($koneksi, "SELECT * FROM news ORDER BY tgl_dibuat ASC");
                        while ($row1 = mysqli_fetch_assoc($cek_news1)) {
                            $a = strtotime($data_news['tgl_dibuat']);
                            $b = date('M d, Y', $a);
                    ?>
                    
                  <div class="post-item mt-3">
                    <img src="../assets/img/news/<?php echo $row1['banner']; ?>" alt="">
                    <div>
                      <h4><a href="<?php echo $weburl . "/berita/berita.php?id_news=" . $row1['id_news']; ?>"><?php echo $row1['judul'] ?></a></h4>
                      <time datetime="2020-01-01"><?php echo $b ?></time>
                    </div>
                  </div><!-- End recent post item-->
                  
                  <?php } ?>

                </div>
                
                <div class="sidebar-item categories mt-3">
                <h3 class="sidebar-title">Kategori</h3>
                <ul class="mt-3">
                    <?php 
                        $kp = mysqli_query($koneksi, "SELECT * FROM news WHERE kategori = 'Peristiwa'");
                        $ke = mysqli_query($koneksi, "SELECT * FROM news WHERE kategori = 'Edukasi'");
                        $kk = mysqli_query($koneksi, "SELECT * FROM news WHERE kategori = 'Kreatif'");
                        $kke = mysqli_query($koneksi, "SELECT * FROM news WHERE kategori = 'Kesehatan'");
                    ?>
                  <li><a href="#">Peristiwa <span>(<?php echo mysqli_num_rows($kp); ?>)</span></a></li>
                  <li><a href="#">Edukasi <span>(<?php echo mysqli_num_rows($ke); ?>)</span></a></li>
                  <li><a href="#">Kreatif <span>(<?php echo mysqli_num_rows($kk); ?>)</span></a></li>
                  <li><a href="#">Kesehatan <span>(<?php echo mysqli_num_rows($kke); ?>)</span></a></li>
                </ul>
              </div><!-- End sidebar categories-->

              </div><!-- End sidebar recent posts-->

              <div class="sidebar-item tags">
                <h3 class="sidebar-title">Tags</h3>
                <div class="mt-3">
                    <strong>
                        <?php 
                            $hastag = $data_news['hastag'];
                            echo preg_replace('/[ ,]+/', ' ', trim($hastag));
                        ?>
                    </strong>
                </div>
              </div><!-- End sidebar tags-->

            </div><!-- End Blog Sidebar -->

          </div>
        </div>

      </div>
    </section><!-- End Blog Details Section -->

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