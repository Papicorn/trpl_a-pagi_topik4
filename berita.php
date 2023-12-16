<?php 
session_start();
 require 'koneksi.php';
 require 'config.php';
 
 $cek_settings = mysqli_query($koneksi, "SELECT * FROM settings");
 $data_settings = mysqli_fetch_assoc($cek_settings);
 
 $cek_news = mysqli_query($koneksi, "SELECT * FROM news ORDER BY tgl_dibuat DESC");
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Berita - <?php echo $data_settings['title'] ?></title>
  <meta content="" name="description">
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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog pt-4">
        
      <div class="container" data-aos="fade-up">
          
            <div class="row mb-4">
                <div class="justify-content-start col-md-6 col-sm-12">
                    <h2>Berita</h2>
                </div>
                <div class="justify-content-end col-md-6 col-sm-12">
                    <div class="col-md-12">
                        <form method="POST" class="d-flex">
                            <select class="form-select me-2 border shadow" id="kategori" aria-label="Kategori" style="width: 100px;">
                                <option value="" selected disabled>Filter</option>
                                <option value="kategori">Kategori</option>
                                <option value="judul">Judul</option>
                            </select>
                            <input class="form-control me-2 border shadow" type="search" placeholder="Search" id="cari" aria-label="Search" required>
                            <button class="btn btn-primary" type="submit" id="submit">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
            
        <div class="row gy-4 posts-list" id="list-berita">
            
            <?php 
                while ($data = mysqli_fetch_assoc($cek_news)) {
                    
            ?>
              <div class="col-xl-4 col-md-6">
                <article>
                  <div class="post-img">
                    <img src="assets/img/news/<?php echo $data['banner']; ?>" alt="" class="img-fluid">
                  </div>
                  <label class="text-muted" style="font-size: 14px;">Berita / <?php echo $data['kategori'] ?></label>
                  <h5><a href="<?php echo $weburl . "/berita/berita.php?id_news=" . $data['id_news'] ;?>" title="More Details" class="text-dark"><?php echo $data['judul']; ?></a></h5>
                  <p style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" class="mb-0 text-muted"><?php echo htmlspecialchars($data['isi_news']); ?></p>
                </article>
              </div><!-- End post list item -->
            <?php 
                }
            ?>

        </div><!-- End blog posts list -->
            
        </div>

        <div class="blog-pagination">
          <ul class="justify-content-center">
            <li><a href="#">1</a></li>
            <li class="active"><a href="#">2</a></li>
            <li><a href="#">3</a></li>
          </ul>
        </div><!-- End blog pagination -->

      </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>
  
  <?php require 'lib/footer.php'; ?>
  
<script type="text/javascript">
    $(document).ready(function(){
        $("#cari").on('input change', function() {
        var search = $('#cari').val();
        var kategori = $('#kategori').val();
            $.ajax({
                url: 'ajax/search_news.php',
                data: { search: search, kategori: kategori }, // Menggunakan objek untuk data
                type: 'POST',
                dataType: 'html',
                success: function(data) {
                    $("#list-berita").html(data); // Mengubah nilai input teks #isi
                },
                error: function(xhr, status, error) {
                    console.error(error); // Menampilkan pesan error di konsol
                }
            });
        });
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
  
 

</body>

</html>