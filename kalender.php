<?php 
    session_start();
  require "koneksi.php";

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

  <title>Kalender Kegiatan - <?php echo $data_settings['title'] ?></title>
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
  
  <!-- fullcalendar css  -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css' rel='stylesheet' />
  <!-- =======================================================
  * Template Name: Impact
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/impact-bootstrap-business-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

</head>

<body>

  <?php require 'lib/navbar.php'; ?>
  <!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-color: #428BFF;">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2>Kalender Kegiatan</h2>
              <p>Kalender kegiatan merupakan kalender yang dapat digunakan untuk melihat informasi kapan kegiatan akan dimulai dan sudah dimulai.</p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="<?php echo $weburl; ?>">Home</a></li>
            <li>Kalender Kegiatan</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->

    <section class="sample-page">
      <div class="container" data-aos="fade-up">
        
        <div class="shadow p-1">
            <div id="calendar"></div>
        </div>

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>
  
  <!-- ====== Calendar ====== -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: [ 
                        <?php 
                            while ($dk = mysqli_fetch_array($cek_kegiatan)) {
                                if ($dk['kategori'] == "Gotong Royong") {
                                    $color = 'green';
                                } elseif ($dk['kategori'] = "Sosialisasi") {
                                    $color = 'orange';
                                } else {
                                    $color = "blue";
                                }
                        ?>
                        {
                            title: '<?php echo $dk['judul_kegiatan']; ?>',
                            start: '<?php echo $dk['tgl_mulai'] . " " . $dk['waktu_mulai']; ?>',
                            end: '<?php echo $dk['tgl_selesai'] . " " . $dk['waktu_selesai']; ?>',
                            url: 'https://kitapeduli.molba.xyz/kegiatan/kegiatan.php?id_kegiatan=<?php echo $dk['id_kegiatan']; ?>',
                            color: '<?php echo $color ?>'
                        },
                        <?php } ?>
                        
                    ],
                    selectOverlap: function (event) {
                        return event.rendering === 'background';
                    }
                    
                });
    
                calendar.render();
            });
        </script>

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

<?php require "lib/footer.php" ?>
</body>

</html>