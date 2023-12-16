<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- fullcalendar css  -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css' rel='stylesheet' />
</head>
<body>
  <section class="content">
    <div class="container-fluid">

      <!-- Kalender -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
              <div class="col-12 d-flex justify-content-center">
                  <div id="calendar" class="col-sm-12 col-md-8"></div>
              </div>
          </div>
        </div>
      </section>
      <!-- /.content -->

      <!-- Your existing scripts, including the jQuery and calendar initialization -->
      <section class="content mt-3">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-sm-12">
                <div class="d-flex justify-content-between">
                  <h3>Kegiatan</h3>
                    <a class="text-link d-flex align-items-center" href="sidebar/kegiatan.php">
                      Lihat Selengkapnya
                    </a>
                </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- card kegiatan -->
      <div class="content">
        <div class="container-fluid mb-3">
          <div class="row overflow-auto flex-nowrap" id="scrollContainer">
              <?php 
                $cek_kegiatan1 = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY tgl_dibuat DESC LIMIT 10");
                while ($row = mysqli_fetch_assoc($cek_kegiatan1)) {
                    
                    $selesai = $row['tgl_selesai'] . " " . $row['waktu_selesai'];
                    $mulai = $row['tgl_mulai'] . " " . $row['waktu_mulai'];
                    
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
              
            <div class="col-md-4 col-10 d-flex">
              <div class="card flex-fill" onclick="window.location.href='<?= $weburl ?>/kegiatan/kegiatan.php?id_kegiatan=<?= $row['id_kegiatan']; ?>'" style="border-radius: 10px; cursor: pointer;">
                <img src="../../assets/img/kegiatan/<?= $row['banner'] ?>" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <div class="card-body">
                  <label class="text-muted mb-0 font-weight-normal" style="font-style: 13px;">Kategori / <?= $row['kategori'] ?></label><span class="badge badge-<?php echo $bg ?> text-light" style="float: right;"><?php echo $status; ?></span>
                  <h5 class="card-title" style="font-weight: bold;"><?= $row['judul_kegiatan'] ?></h5>
                  <div class="card-text" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 1.5rem;" id="beritaD"><?= $row['isi_kegiatan'] ?></div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      
      <section class="content mt-3">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-sm-12">
                <div class="d-flex justify-content-between">
                  <h3>Berita</h3>
                    <a class="text-link d-flex align-items-center" href="sidebar/berita.php">
                      Lihat Selengkapnya
                    </a>
                </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- card kegiatan -->
      <div class="content">
        <div class="container-fluid mb-3">
          <div class="row overflow-auto flex-nowrap" id="scrollContainer">
              <?php 
                $cek_berita1 = mysqli_query($koneksi, "SELECT * FROM news ORDER BY tgl_dibuat DESC LIMIT 10");
                while ($row1 = mysqli_fetch_assoc($cek_berita1)) {
                    
              ?>
              
            <div class="col-md-4 col-10 d-flex">
              <div class="card flex-fill" onclick="window.location.href='<?= $weburl ?>/berita/berita.php?id_news=<?= $row1['id_news']; ?>'" style="border-radius: 10px; cursor: pointer;">
                <img src="../../assets/img/news/<?= $row1['banner'] ?>" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <div class="card-body">
                  <label class="text-muted mb-0 font-weight-normal" style="font-style: 13px;">Berita / <?= $row1['kategori'] ?></label><br>
                  <h5 class="card-title" style="font-weight: bold;"><?= $row1['judul'] ?></h5>
                  <div class="card-text" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 1.7rem;" id="beritaD"><?= $row1['isi_news'] ?></div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      
      <!-- Tabel anggota -->
      
      <!-- /.row -->
    </div>
  </section>
  
            <script>
                // Mendapatkan elemen div
                var myDiv = document.getElementById('beritaD');
                
                // Mengambil teks dari elemen div (tanpa elemen HTML)
                var textOnly = myDiv.textContent || myDiv.innerText;
                
                // Menampilkan teks yang hanya berisi teks (tanpa elemen HTML)
                console.log(textOnly); // atau Anda bisa menampilkan di mana saja sesuai kebutuhan

            </script>
</body>
</html>
