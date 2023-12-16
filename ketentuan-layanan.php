<?php 
  require "koneksi.php";

  $cek_settings = mysqli_query($koneksi, "SELECT * FROM settings WHERE id = '1'");
  $data_settings = mysqli_fetch_assoc($cek_settings);
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
              <h2>Ketentuan Layanan</h2>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="<?php echo $weburl; ?>">Home</a></li>
            <li>Kebijakan Privasi</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->

    <section class="sample-page">
      <div class="container" data-aos="fade-up">
      
        <h1>Syarat dan Ketentuan Penggunaan Situs Web</h1>
        <h2>1. Istilah</h2>
        <p>Dengan mengakses Situs Web ini, yang dapat diakses dari https://kitapeduli.molba.xyz, Anda setuju untuk terikat oleh Syarat dan Ketentuan Penggunaan Situs Web ini dan menyetujui bahwa Anda bertanggung jawab atas kesepakatan dengan semua hukum lokal yang berlaku. Jika Anda tidak setuju dengan salah satu syarat ini, Anda dilarang untuk mengakses situs ini. Materi yang terdapat dalam Situs Web ini dilindungi oleh hukum hak cipta dan merek dagang.</p>
        <h2>2. Lisensi Penggunaan</h2>
        <p>Izin diberikan untuk mengunduh sementara satu salinan materi di Situs Web kitapeduli.id untuk tontonan pribadi, non-komersial, dan sementara. Ini adalah pemberian lisensi, bukan transfer judul, dan di bawah lisensi ini Anda tidak boleh:</p>
        <ul>
          <li>memodifikasi atau menyalin materi;</li>
          <li>menggunakan materi untuk tujuan komersial atau tampilan publik;</li>
          <li>mencoba untuk meretas perangkat lunak apa pun yang terdapat di Situs Web kitapeduli.id;</li>
          <li>menghapus notasi hak cipta atau properti lainnya dari materi; atau</li>
          <li>mentransfer materi ke orang lain atau "mencerminkan" materi di server lain.</li>
        </ul>
        <p>Ini akan memungkinkan kitapeduli.id untuk mengakhiri hak Anda atas pelanggaran salah satu pembatasan ini. Setelah pengakhiran, hak tontonan Anda juga akan diakhiri dan Anda harus menghancurkan semua materi yang diunduh yang berada dalam kepemilikan Anda, baik dalam bentuk cetak maupun elektronik. Ketentuan Layanan ini telah dibuat dengan bantuan dari <a href="https://www.termsofservicegenerator.net">Pembuat Ketentuan Layanan</a>. </p>
        <h2>3. Penafian</h2>
        <p>Semua materi di Situs Web kitapeduli.id disediakan "sebagaimana adanya". kitapeduli.id tidak memberikan jaminan, baik itu tersurat maupun tersirat, dan oleh karena itu meniadakan semua jaminan lainnya. Selanjutnya, kitapeduli.id tidak membuat representasi mengenai akurasi atau kehandalan penggunaan materi di Situs Web ini atau sehubungan dengan materi tersebut atau situs yang terhubung ke Situs Web ini.</p>
        <h2>4. Pembatasan</h2>
        <p>kitapeduli.id atau pemasoknya tidak akan bertanggung jawab atas kerusakan apa pun yang mungkin timbul dari penggunaan atau ketidakmampuan menggunakan materi di Situs Web kitapeduli.id, bahkan jika kitapeduli.id atau perwakilan yang sah dari Situs Web ini telah diberitahu, lisan atau tertulis, tentang kemungkinan kerusakan tersebut. Beberapa yurisdiksi tidak mengizinkan pembatasan pada jaminan tersirat atau pembatasan tanggung jawab atas kerusakan kebetulan, pembatasan ini mungkin tidak berlaku untuk Anda.</p>
        <h2>5. Revisi dan Kesalahan</h2>
        <p>Materi yang muncul di Situs Web kitapeduli.id dapat mencakup kesalahan teknis, tipografi, atau fotografi. kitapeduli.id tidak menjamin bahwa semua materi di Situs Web ini akurat, lengkap, atau terkini. kitapeduli.id dapat mengubah materi yang terdapat di Situs Web ini kapan saja tanpa pemberitahuan. kitapeduli.id tidak membuat komitmen untuk memperbarui materi.</p>
        <h2>6. Tautan</h2>
        <p>kitapeduli.id belum meninjau semua situs yang terhubung ke Situs Web ini dan tidak bertanggung jawab atas isi dari situs yang terhubung tersebut. Keberadaan tautan tidak menyiratkan pengesahan oleh kitapeduli.id terhadap situs tersebut. Penggunaan setiap situs web yang terhubung adalah risiko pengguna sendiri.</p>
        <h2>7. Modifikasi Ketentuan Penggunaan Situs</h2>
        <p>kitapeduli.id dapat merevisi Syarat Penggunaan untuk Situs Web ini kapan saja tanpa pemberitahuan sebelumnya. Dengan menggunakan Situs Web ini, Anda setuju untuk terikat oleh versi terbaru dari Syarat dan Ketentuan Penggunaan ini.</p>
        <h2>8. Privasi Anda</h2>
        <p>Silakan baca Kebijakan Privasi kami.</p>
        <h2>9. Hukum yang Berlaku</h2>
        <p>Setiap klaim terkait Situs Web kitapeduli.id akan tunduk pada hukum id tanpa memperhatikan ketentuan konflik hukumnya.</p>
        
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>
  
  <!-- ====== Calendar ====== -->

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