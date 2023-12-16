 <!-- Footer -->
 <?php 
    $cek_settings = mysqli_query($koneksi, "SELECT * FROM settings WHERE id = '1'");
    $data_settings = mysqli_fetch_assoc($cek_settings);
?>
  <footer
          class="text-center text-lg-start text-white"
          style="background-color: #1c2331"
          >
    <!-- Section: Social media -->
    <section
             class="d-flex justify-content-between p-4"
             style="background-color: #428bff"
             >
      <!-- Left -->
      <div class="me-5">
        <span>Get connected with us on social networks:</span>
      </div>
      <!-- Left -->

      <!-- Right -->
      <div>
        <a href="" class="text-white me-4">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fab fa-google"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fab fa-github"></i>
        </a>
      </div>
      <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            
            <h6 class="text-uppercase fw-bold"><img src="<?php echo $weburl ?>/assets/image/kitapeduli.png" alt="kitapeduli.id" style="width: 130px;"></h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p>
            <?php echo $data_settings['description'] ?>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">navigasi</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p>
              <a href="<?php echo $weburl; ?>" class="text-white">Home</a>
            </p>
            <p>
              <a href="<?php echo $weburl; ?>/auth/login.php" class="text-white">Login</a>
            </p>
            <p>
              <a href="<?php echo $weburl; ?>/auth/daftar.php" class="text-white">Gabung Sukarelawan</a>
            </p>
            <p>
              <a href="<?php echo $weburl; ?>/auth/daftarkom.php" class="text-white">Gabung Komunitas</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Halaman Lainnya</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p>
              <a href="<?= $weburl ?>/dashboard/user/index.php" class="text-white">Dashboard user</a>
            </p>
            <p>
              <a href="<?= $weburl ?>/dashboard/community/index.php" class="text-white">Dashboard komunitas</a>
            </p>
            <p>
              <a href="<?php echo $weburl ?>/kalender.php" class="text-white">Kalender</a>
            </p>
            <p>
              <a href="<?php echo $weburl ?>/kegiatan.php" class="text-white">Kegiatan</a>
            </p>
            <p>
              <a href="<?php echo $weburl ?>/berita.php" class="text-white">Berita</a>
            </p>
            <p>
              <a href="<?php echo $weburl ?>/kebijakan-privasi.php" class="text-white">Kebijakan privasi</a>
            </p>
            <p>
              <a href="<?php echo $weburl ?>/ketentuan-layanan.php" class="text-white">Ketentuan layanan</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold">Kontak</h6>
            <hr
                class="mb-4 mt-0 d-inline-block mx-auto"
                style="width: 60px; background-color: #7c4dff; height: 2px"
                />
            <p><i class="fas fa-home mr-3"></i> <?php echo $data_settings['alamat'] ?></p>
            <p><i class="fas fa-envelope mr-3"></i> <?php echo $data_settings['email'] ?></p>
            <p><i class="fas fa-phone mr-3"></i> <?php echo $data_settings['no_telpon'] ?></p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div
         class="text-center p-3"
         style="background-color: rgba(0, 0, 0, 0.2)"
         >
      © 2023 Copyright:
      <a class="text-white" href="#"
         ><?php echo $data_settings['title'] ?></a
        >
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
  <script>
      $(function(){
    var current = location.pathname;
    $('#navbar li a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $this.addClass('active');
        }
    })
})
  </script>
</body>
</html>