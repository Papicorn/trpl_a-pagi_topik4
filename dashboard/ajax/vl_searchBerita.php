<?php 
session_start();
require '../../koneksi.php';
require '../../config.php';

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $kategori = $_POST['kategori'];
    
    if($kategori == "judul") {
        $cek_berita = mysqli_query($koneksi, "SELECT * FROM news WHERE judul LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    } elseif($kategori == "kategori") {
        $cek_berita = mysqli_query($koneksi, "SELECT * FROM news WHERE kategori LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    } else {
      $cek_berita = mysqli_query($koneksi, "SELECT * FROM news WHERE judul LIKE '%$search%' ORDER BY tgl_dibuat DESC");  
    }
    
                while ($row = mysqli_fetch_assoc($cek_berita)) {
                    
              ?>
              
            <div class="col-md-4 col-12 d-flex">
              <div class="card flex-fill" onclick="window.location.href='<?= $weburl ?>/berita/berita.php?id_news=<?= $row['id_news']; ?>'" style="border-radius: 10px; cursor: pointer;">
                <img src="../../../assets/img/news/<?= $row['banner'] ?>" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <div class="card-body">
                  <label class="text-muted mb-0 font-weight-normal" style="font-style: 13px;">Berita / <?= $row['kategori'] ?></label><br>
                  <h5 class="card-title" style="font-weight: bold;"><?= $row['judul'] ?></h5>
                  <div class="card-text" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 1.7rem;" id="beritaD"><?= $row['isi_news'] ?></div>
                </div>
              </div>
            </div>
            <?php }
}
?>
