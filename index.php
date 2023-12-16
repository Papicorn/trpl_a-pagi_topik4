<?php 
    session_start();
  require "koneksi.php";
  require "config.php";

  $cek_settings = mysqli_query($koneksi, "SELECT * FROM settings WHERE id = '1'");
  $data_settings = mysqli_fetch_assoc($cek_settings);

  $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE level = 'user'");
  $hitung_user = mysqli_num_rows($cek_user);

  $cek_komunitas = mysqli_query($koneksi, "SELECT * FROM community");
  $hitung_komunitas = mysqli_num_rows($cek_komunitas);

  $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan");
  $hitung_kegiatan = mysqli_num_rows($cek_kegiatan);
  
  $cek_news = mysqli_query($koneksi, "SELECT * FROM news");

  $cek_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan");
  $hitung_ulasan = mysqli_num_rows($cek_ulasan);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $data_settings['title'] ?> - Website Komunitas Sukarelawan</title>
  <meta content="<?php echo $data_settings['description'] ?>" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Impact
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/impact-bootstrap-business-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body>

  <!-- ======= Header ======= -->
  <!-- End Top Bar -->

  <?php require 'lib/navbar.php'; ?>
  <!-- End Header -->
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero" style="background-color: #428BFF;">
    <div class="container position-relative">
      <div class="row gy-5" data-aos="fade-in">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
          <h2>Selamat Datang di <span style="color: orange;"><?php echo $data_settings['title']; ?></span></h2>
          <p><?php echo $data_settings['description'] ?></p>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="<?php echo $weburl; ?>/auth/daftar.php" class="btn-get-started">Gabung Sukarelawan!</a>
            <a href="<?php echo $weburl; ?>/auth/daftarkom.php" class="btn-get-started" style="margin-left: 15px;">Gabung Komunitas!</a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2">
          <img src="<?php echo $weburl; ?>/assets/img/dsbhd.png" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
        </div>
      </div>
    </div>

    <div class="icon-boxes position-relative">
      <div class="container position-relative">
        <div class="row gy-4 mt-5">

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="icon-box py-3" style="background-color: #619eff;">
              <div class="icon"><i class="bi bi-person-fill"></i></div>
              <h4 class="title"><a href="" class="stretched-link"><?php echo $hitung_user; ?></a></h4>
              <p><strong>Sukarelawan</strong></p>
            </div>
          </div><!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box py-3" style="background-color: #619eff;">
              <div class="icon"><i class="bi bi-person-workspace"></i></div>
              <h4 class="title"><a href="" class="stretched-link"><?php echo $hitung_kegiatan; ?></a></h4>
              <p><strong>Kegiatan</strong></p>
            </div>
          </div><!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box py-3" style="background-color: #619eff;">
              <div class="icon"><i class="bi bi-people-fill"></i></div>
              <h4 class="title"><a href="" class="stretched-link"><?php echo $hitung_komunitas; ?></a></h4>
              <p><strong>Komunitas</strong></p>
            </div>
          </div><!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="icon-box py-3" style="background-color: #619eff;">
              <div class="icon"><i class="bi bi-chat-dots-fill"></i></div>
              <h4 class="title"><a href="" class="stretched-link"><?php echo $hitung_ulasan; ?></a></h4>
              <p><strong>Ulasan</strong></p>
            </div>
          </div><!--End Icon Box -->

        </div>
      </div>
    </div>

    </div>
  </section>
  <!-- End Hero Section -->

  <main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Tentang Kami</h2>
          <p><?php echo $data_settings['description'] ?></p>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- Location -->
    <section class="services pt-0" id="services">
        <div class="section-header pb-1">
          <h2>Lokasi Kami</h2>
        </div>
        <div id="map" style="height:380px;margin:0 auto;margin-bottom:10px;" class="col-10"></div>
    </section>
    <!-- end location -->

    

    <!-- ======= Testimonials Section ======= -->
    <!-- End Testimonials Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio sections-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Aktivitas</h2>
        </div>

        <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order" data-aos="fade-up" data-aos-delay="100">

          <div>
            <ul class="portfolio-flters">
              <li data-filter="*" class="filter-active">Semua</li>
              <li data-filter=".filter-product">Kegiatan</li>
              <li data-filter=".filter-app">Berita</li>
            </ul><!-- End Portfolio Filters -->
          </div>

          <div class="row gy-4 portfolio-container">
              
              <?php 
                $while_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY tgl_dibuat DESC LIMIT 3");
                while ($data_kegiatan = mysqli_fetch_assoc($while_kegiatan)) {
                    
                    $selesai = $data_kegiatan['tgl_selesai'] . " " . $data_kegiatan['waktu_selesai'];
                    $mulai = $data_kegiatan['tgl_mulai'] . " " . $data_kegiatan['waktu_mulai'];
                    
                    if (strtotime($today) >= strtotime($mulai) && strtotime($today) <= strtotime($selesai)) {
                        $status = "Berlangsung";
                        $bg = "warning";
                    } elseif (strtotime($today) <= strtotime($mulai)) {
                        $status = "Belum dimulai";
                        $bg = "success";
                    } else {
                        $status = "Selesai";
                        $bg = "danger";
                    }
                    
              ?>

            <div class="col-xl-4 col-md-6 portfolio-item filter-product">
              <div class="portfolio-wrap">
                <a href="<?php echo $weburl . "/kegiatan/kegiatan.php?id_kegiatan=" . $data_kegiatan['id_kegiatan'] ;?>" data-gallery="portfolio-gallery-app" class="glightbox"><img src="assets/img/kegiatan/<?php echo $data_kegiatan['banner']; ?>" class="img-fluid" alt=""></a>
                <div class="portfolio-info pt-3">
                    <label class="text-muted" style="font-size: 14px;">Kegiatan / <?php echo $data_kegiatan['kategori'] ?></label><span class="badge bg-<?php echo $bg ?>" style="float: right;"><?php echo $status; ?></span>
                  <h4><a href="<?php echo $weburl . "/kegiatan/kegiatan.php?id_kegiatan=" . $data_kegiatan['id_kegiatan'] ;?>" title="More Details"><?php echo $data_kegiatan['judul_kegiatan']; ?></a></h4>
                  <p style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo htmlspecialchars($data_kegiatan['isi_kegiatan']); ?></p>
                </div>
              </div>
            </div><!-- End Portfolio Item -->
            
                <?php } 
                    $while_news = mysqli_query($koneksi, "SELECT * FROM news ORDER BY tgl_dibuat DESC LIMIT 3");
                    while ($data_news = mysqli_fetch_assoc($while_news)) {
                        
                ?>

            <div class="col-xl-4 col-md-6 portfolio-item filter-app">
              <div class="portfolio-wrap">
                <a href="<?php echo $weburl . "/berita/berita.php?id_news=" . $data_news['id_news'] ;?>" data-gallery="portfolio-gallery-app" class="glightbox"><img src="assets/img/news/<?php echo $data_news['banner']; ?>" class="img-fluid" alt=""></a>
                <div class="portfolio-info pt-3">
                    <label class="text-muted" style="font-size: 14px;">Berita</label>
                  <h4><a href="<?php echo $weburl . "/news/news.php?id_news=" . $data_news['id_news'] ;?>" title="More Details"><?php echo $data_news['judul']; ?></a></h4>
                  <p style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo $data_news['isi_news']; ?></p>
                </div>
              </div>
            </div><!-- End Portfolio Item -->
            
                <?php } ?>

          </div><!-- End Portfolio Container -->

        </div>

      </div>
    </section><!-- End Portfolio Section -->

    <!-- ======= Our Team Section ======= -->
    <section id="team" class="team">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Team Kami</h2>
        </div>

        <div class="row gy-5 d-flex justify-content-center">

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <img src="assets/img/team/team-8.jpg" class="img-fluid" alt="">
              <h4>M Afif Alfawwaz</h4>
              <span>Back End Developer</span>
              <div class="social">
                <a href=""><i class="bi bi-instagram"></i></a>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
              <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
              <h4>Ririn Fitri W</h4>
              <span>Front End Developer</span>
              <div class="social">
                <a href=""><i class="bi bi-instagram"></i></a>
              </div>
            </div>
          </div><!-- End Team Member -->
          
           <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <img src="assets/img/team/team-5.jpg" class="img-fluid" alt="">
              <h4>Einstein</h4>
              <span>Analyst</span>
              <div class="social">
                <a href=""><i class="bi bi-instagram"></i></a>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
              <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
              <h4>Ahmad Zaki</h4>
              <span>UI/UX Designer</span>
              <div class="social">
                <a href=""><i class="bi bi-instagram"></i></a>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="member">
              <img src="assets/img/team/team-6.jpg" class="img-fluid" alt="">
              <h4>Tabina Rahmah</h4>
              <span>UI/UX Designer</span>
              <div class="social">
                <a href=""><i class="bi bi-instagram"></i></a>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>
    </section><!-- End Our Team Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="content px-xl-5">
              <h3>Pertanyaan yang Sering <strong>Diajukan</strong></h3>
              <p>
                Adalah berbagai pertanyaan yang sering ditanyakan oleh para pengguna. Berikut adalah pertanyaan yang akan mewakili dari setiap pertanyaan anda
              </p>
            </div>
          </div>

          <div class="col-lg-8">

            <div class="accordion accordion-flush" id="faqlist" data-aos="fade-up" data-aos-delay="100">

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-1">
                    <span class="num">1.</span>
                    Bagaimana caranya bergabung sebagai sukarelawan?
                  </button>
                </h3>
                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    untuk bergabung menjadi sukarelawan, anda hanya perlu menekan tombol "Bergabung Sukarelawan!" pada header kami. Kemudian anda akan diminta untuk mengisi data diri anda.
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                    <span class="num">2.</span>
                    Apakah setelah mendaftar menjadi sukarelawan dapat bergabung ke kegiatan?
                  </button>
                </h3>
                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    Ya, setiap akun sukarelawan yang sudah terdaftar, dapat bergabung langsung ke kegiatan yang telah dibuat oleh komunitas.        
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-3">
                    <span class="num">3.</span>
                    Apakah bisa mendaftarkan komunitas disini?
                  </button>
                </h3>
                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    Tentu bisa! kalian hanya perlu mendaftar terlebih dahulu sebagai sukarelawan, lalu kalian dapat menekan tombol "Bergabung Komunitas!" untuk mendaftarkan komunitas pada website.            
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-4">
                    <span class="num">4.</span>
                    Bagaimana jika saya melupakan password dari akun saya?
                  </button>
                </h3>
                <div id="faq-content-4" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    Jika melupakan password yang sudah terdaftar, anda dapat menekan tulisan "Lupa password" pada halaman login. Lalu kalian diminta untuk mengisi kode yang sudah diberikan lewat email sebagai verifikasi apakah email tersebut milik anda.
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-5">
                    <span class="num">5.</span>
                    Jika terjadi kendala pada akun saya, bagaiman saya menghubungi support?
                  </button>
                </h3>
                <div id="faq-content-5" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    Anda dapat menghubungi support dengan mengirimkan pesan melalui <b>support@kitapeduli.molba.xyz</b>. Jika tetap tidak ada balasan, anda dapat mengirimkan pesan melalui Nomor whatsapp yang sudah tertera.
                  </div>
                </div>
              </div><!-- # Faq item-->

            </div>

          </div>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php require "lib/footer.php" ?>
  <!-- End Footer -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  
  <script>
    // Koordinat pusat peta
    var myLatLng = [1.117904, 104.040043];

    // Buat peta
    var map = L.map('map').setView(myLatLng, 19);

    // Tambahkan layer peta dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan penanda di pusat peta
    L.marker(myLatLng).addTo(map)
        .bindPopup('kitapeduli.id Camp!').openPopup();
</script>


</body>

</html>