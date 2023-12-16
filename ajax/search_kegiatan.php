<?php 
require '../koneksi.php';
require '../config.php';

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    
    if($_POST['kategori'] == "judul") {
        $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE judul_kegiatan LIKE '%$search%' ORDER BY tgl_dibuat DESC");    
    } elseif ($_POST['kategori'] == "kategori") {
        $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE kategori LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    } else {
        $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE judul_kegiatan LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    }
    
    
    while ($data = mysqli_fetch_assoc($cek_kegiatan)) { 
        $selesai = $data['tgl_selesai'] . " " . $data['waktu_selesai'];
                    $mulai = $data['tgl_mulai'] . " " . $data['waktu_mulai'];
                    
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
<div class="col-xl-4 col-md-6">
    <article>
        <div class="post-img">
            <img src="assets/img/kegiatan/<?php echo $data['banner']; ?>" alt="" class="img-fluid">
        </div>
        <label class="text-muted" style="font-size: 14px;">Kegiatan / <?php echo $data['kategori'] ?></label><span class="badge bg-<?php echo $bg ?>" style="float: right;"><?php echo $status; ?></span>
        <h5><a href="<?php echo $weburl . "/kegiatan/kegiatan.php?id_kegiatan=" . $data['id_kegiatan'] ;?>" title="More Details" class="text-dark"><?php echo $data['judul_kegiatan']; ?></a></h5>
        <p style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" class="mb-0 text-muted"><?php echo htmlspecialchars($data['display_text']); ?></p>
    </article>
</div><!-- End post list item -->   
        
<?php
    }
}

?>