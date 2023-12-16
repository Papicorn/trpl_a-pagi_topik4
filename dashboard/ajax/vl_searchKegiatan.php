<?php 
session_start();
require '../../koneksi.php';
require '../../config.php';

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $kategori = $_POST['kategori'];
    
    if($kategori == "judul") {
        $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE judul_kegiatan LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    } elseif($kategori == "kategori") {
        $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE kategori LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    } else {
      $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE judul_kegiatan LIKE '%$search%' ORDER BY tgl_dibuat DESC");  
    }
    
                while ($row = mysqli_fetch_assoc($cek_kegiatan)) {
                    
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
              
            <div class="col-md-4 col-12 d-flex">
              <div class="card flex-fill" onclick="window.location.href='<?= $weburl ?>/kegiatan/kegiatan.php?id_kegiatan=<?= $row['id_kegiatan']; ?>'" style="border-radius: 10px; cursor: pointer;">
                <img src="../../../assets/img/kegiatan/<?= $row['banner'] ?>" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <div class="card-body">
                  <label class="text-muted mb-0 font-weight-normal" style="font-style: 13px;">Kategori / <?= $row['kategori'] ?></label><span class="badge badge-<?php echo $bg ?> text-light" style="float: right;"><?php echo $status; ?></span><br>
                  <h5 class="card-title" style="font-weight: bold;"><?= $row['judul_kegiatan'] ?></h5>
                  <div class="card-text" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 1.5rem;" id="beritaD"><?= $row['isi_kegiatan'] ?></div>
                </div>
              </div>
            </div>
            <?php }
}
?>
