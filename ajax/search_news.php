<?php 
require '../koneksi.php';
require '../config.php';

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    
    if($_POST['kategori'] == "judul") {
        $cek_news = mysqli_query($koneksi, "SELECT * FROM news WHERE judul LIKE '%$search%' ORDER BY tgl_dibuat DESC");    
    } elseif ($_POST['kategori'] == "kategori") {
        $cek_news = mysqli_query($koneksi, "SELECT * FROM news WHERE kategori LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    } else {
        $cek_news = mysqli_query($koneksi, "SELECT * FROM news WHERE judul LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    }
    
    
    while ($data = mysqli_fetch_assoc($cek_news)) { 
        
    ?>
<div class="col-xl-4 col-md-6">
    <article>
        <div class="post-img">
            <img src="assets/img/news/<?php echo $data['banner']; ?>" alt="" class="img-fluid">
        </div>
        <label class="text-muted" style="font-size: 14px;">Berita / <?php echo $data['kategori'] ?></label>
        <h5><a href="<?php echo $weburl . "/berita/berita.php?id_news=" . $data['id_news'] ;?>" title="More Details" class="text-dark"><?php echo $data['judul']; ?></a></h5>
        <p style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" class="mb-0 text-muted"><?php echo htmlspecialchars($data['display_text']); ?></p>
    </article>
</div><!-- End post list item -->  
        
<?php
    }
}

?>