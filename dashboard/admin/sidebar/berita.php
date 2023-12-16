<?php 
session_start();
require '../../../koneksi.php';
require '../../../config.php';

if(!isset($_SESSION['email'])){
        header('Location: ' . $weburl . '/auth/login.php');
    }
        $email = $_SESSION['email'];
        
        $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$email' OR email = '$email'");
        $data_user = mysqli_fetch_assoc($cek_user);
        
        if ($data_user['level'] != "admin") {
            header('Location: ' . $weburl . '/dashboard/user/index.php');
        }
        
        $id_user = $data_user['id_user'];
        

// CEK
$cek_settings = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
$cek_community = mysqli_query($koneksi, "SELECT * FROM community");
$cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan");

// DATA
$data_settings = mysqli_fetch_assoc($cek_settings);
$data_community = mysqli_fetch_assoc($cek_community);

// JUMLAH
$jumlah_kegiatan = mysqli_num_rows($cek_kegiatan);

$targetDirectory = "../../../assets/img/news/";

if (isset($_POST['simpan'])) {
    $judul = $koneksi->real_escape_string($_POST['judul']);
    $kategori = $koneksi->real_escape_string($_POST['kategori']);
    $isi = $koneksi->real_escape_string($_POST['isi']);
    $banner = $koneksi->real_escape_string($_POST['banner']);
    $hastag = $koneksi->real_escape_string($_POST['hastag']);
    
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $banner = basename($_FILES["file"]["name"]);
    
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    
    if ($_FILES["file"]["size"] > 1000000) {
        $uploadOk = 0;
    }
    
    // Hanya izinkan format gambar tertentu
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        $uploadOk = 0;
    }
    
    
    if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
        if (mysqli_query($koneksi, "INSERT INTO `news` VALUES ('','$judul','$isi','$kategori','$hastag','$banner','$id_user','$today')") == TRUE) {
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)){
                $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Yey anda berhasil membuat berita baru!', 'pesan' => 'Berhasil');
            } else {
                $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan yang terjadi ketika menambahkan banner!', 'pesan' => 'Gagal');
            }
        } else {
            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan yang terjadi ketika menambahkan kegiatan baru!', 'pesan' => 'Gagal');
        }
    } else {
        $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Banner tidak boleh kosong, masukkan banner terlebih dahulu!', 'pesan' => 'Gagal');
    }
}else if (isset($_POST['hapus'])) {
        $id_news = $_GET['id_news'];
        $file_name = $_GET['banner'];
        $path =  "../../../assets/img/news/$file_name";
        
        $cek = mysqli_query($koneksi, "SELECT * FROM news WHERE id_news = '$id_news'");
        
        if(mysqli_num_rows($cek) == 0) {
            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Berita tidak tersedia!', 'pesan' => 'Gagal');
        } else {          
            if (mysqli_query($koneksi, "DELETE FROM news WHERE id_news = '$id_news'") == TRUE) {
                unlink($path);
                $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Berhasil menghapus news yang dipilih!', 'pesan' => 'Berhasil');
            } else {
                $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Gagal menghapus news yang dipilih!', 'pesan' => 'Gagal');
            }
        }
    } else if (isset($_POST['ubah'])) {
        $id_news = $koneksi->real_escape_string($_POST['id_news']);
        
        $judul = $koneksi->real_escape_string($_POST['judul']);
        $kategori = $koneksi->real_escape_string($_POST['kategori']);
        $isi = $koneksi->real_escape_string($_POST['isi']);
        $banner = $koneksi->real_escape_string($_POST['banner']);
        $hastag = $koneksi->real_escape_string($_POST['hastag']);
        
        if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
            $path =  "<?= $weburl ?>/assets/img/news/$banner";
            unlink($path);
            
            $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
            $banner = basename($_FILES["file"]["name"]);
            
            $check = getimagesize($_FILES["file"]["tmp_name"]);
        }
        
        if (mysqli_query($koneksi, "UPDATE `news` SET `judul`='$judul',`isi_news`='$isi',`kategori`='$kategori',`banner`='$banner', hastag = '$hastag' WHERE id_news = '$id_news'") == TRUE){
            if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
                move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
            } 
            $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil mengubah detail berita! ', 'pesan' => 'Berhasil');
        } else {
            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan yang terjadi ketika mengubah data!', 'pesan' => 'Gagal');
        }
    }

?>

<!DOCTYPE html>
<html>
<?php include ('../header.php')?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include ('../navbar.php') ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    <?php include('../sidebar.php')?>
    <!-- /.sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <?php  
                if(isset($_SESSION['alert'])) {
            ?>
            <div class="alert alert-<?= $_SESSION['alert']['alert']; ?> alert-dismissible fade show" role="alert">
              <?= $_SESSION['alert']['judul']; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <?php 
                unset($_SESSION['alert']);
            } ?>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-5 ">
            <h1 class="m-0 text-dark">Berita</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <section class="content">
          <div class="row mb-3">
            <div class="col-sm-12">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-success text-light" data-toggle="modal" data-target="#tambahBerita">
                      <i class="fas fa-plus"></i>  Tambah Berita
                    </a>
                </div>
            </div>
          </div>
        </section>

        <section class="content">
          <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover table-bordered text-nowrap">
                <thead class="bg-warning">
                  <tr>
                    <th>No</th>
                    <th>Judul Berita</th>
                    <th>Kategori</th>
                    <th>Hastag</th>
                    <th>Komentar</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="list-berita">
                    <?php 
                        $jumlahDataPerhalaman = 10;
                        $jumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM news"));
                        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
                        $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
                        $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
                    
                        $no = 1;
                        $cek_berita = mysqli_query($koneksi, "SELECT * FROM news ORDER BY tgl_dibuat DESC LIMIT $awalData, $jumlahDataPerhalaman");
                        while ($row = mysqli_fetch_assoc($cek_berita)) {
                            
                            $id_news1 = $row['id_news'];
                            
                            $cekKomen = mysqli_query($koneksi, "SELECT * FROM komentar WHERE id_news = '$id_news1'");
                            $jumlahKomen = mysqli_num_rows($cekKomen);
                            
                            $tgl_dibuat = date('d M Y', strtotime($row['tgl_dibuat']));
                            
                    ?>
                  <tr>
                      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?id_news=<?= $row['id_news'] ?>&banner=<?= $row['banner'] ?>">
                        <td><?= $awalData =+ 1 ?></td>
                        <td><?= $row['judul']; ?></td>
                        <td><?= $row['kategori']; ?></td>
                        <td><?php
                                $hastag = $row['hastag'];
                                echo preg_replace('/[ ,]+/', ' ', trim($hastag));
                            ?></td>
                        <td><?= $jumlahKomen ?></td>
                        <td><?= $tgl_dibuat; ?></td>
                        <td align="center"><a name="edit" class="btn btn-primary btn-sm text-light" data-toggle="modal" data-target="#ubahNews<?= $row['id_news'] ?>"><i class="fas fa-edit"></i> Ubah</a>
                        <button type="submit" name="hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
                        <a name="show" href="<?= $weburl ?>/berita/berita.php?id_news=<?= $row['id_news'] ?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Lihat</a>
                        </td>
                    </form>
                  </tr>
                  
                    <!-- Modal Ubah kegiatan -->
                      <div class="modal fade" id="ubahNews<?= $row['id_news'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-warning text text-light">
                              <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Ubah News</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input style="hidden" value="<?= $row['id_news'] ?>" name="id_news" hidden> 
                                    <input style="hidden" value="<?= $row['banner'] ?>" name="banner" hidden> 
                                    <div class="form-group">
                                      <label>Judul News</label>
                                      <input type="text" name="judul" class="form-control" placeholder="Masukkan judul" value="<?= $row['judul']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Kategori</label>
                                      <select class="form-control" name="kategori">
                                          <option value="<?= $row['kategori'] ?>" selected><?= $row['kategori'] ?></option>
                                          <option value="Peristiwa">Peristiwa</option>
                                          <option value="Edukasi">Edukasi</option>
                                          <option value="Kreatif">Kreatif</option>
                                          <option value="Kesehatan">Kesehatan</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label>Hastag <small>(Example: #hebat,#kegiatan,#indonesiahebat)</small></label>
                                      <input type="text" name="hastag" class="form-control" placeholder="Masukkan hastag" value="<?= $row['hastag']; ?>">
                                    </div>
                                     <div class="form-group">
                                      <label>Tambahkan Banner <small>(16:9)</small></label>
                                      <input class="form-control" name="file" type="file" accept=".jpg, .png, .jpeg">
                                    </div>
                                    <div class="form-group">
                                      <label>Isi Berita</label>
                                      <textarea class="form-control" name="isi" placeholder="Masukkan isi berita" rows="5"><?= $row['isi_news'] ?></textarea>
                                    </div>
                                  <input type="submit" class="btn btn-success" name="ubah" value="Simpan">
                                </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          
              <div aria-label="Page navigation">
                  <ul class="pagination justify-content-center mt-2">
                    <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                        <?php if ($i == $halamanAktif) : ?>
                            <li class="page-item active" aria-current="page">
                              <a class="page-link" href="?halaman=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item" aria-current="page">
                              <a class="page-link" href="?halaman=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endif; ?>
                        <?php endfor; ?>
                  </ul>
                </div>
        </div>
      </div>
        </section>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

 <!-- Modal Tambah berita -->
  <div class="modal fade" id="tambahBerita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning text text-light">
          <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Berita Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <label>Judul Berita</label>
                                      <input type="text" name="judul" class="form-control" placeholder="Masukkan judul">
                                    </div>
                                    <div class="form-group">
                                      <label>Kategori</label>
                                      <select class="form-control" name="kategori">
                                          <option value="Peristiwa">Peristiwa</option>
                                          <option value="Edukasi">Edukasi</option>
                                          <option value="Kreatif">Kreatif</option>
                                          <option value="Kesehatan">Kesehatan</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label>Hastag <small>(Example: #hebat,#kegiatan,#indonesiahebat)</small></label>
                                      <input type="text" name="hastag" class="form-control" placeholder="Masukkan hastag">
                                    </div>
                                     <div class="form-group">
                                      <label>Tambahkan Banner <small>(16:9)</small></label>
                                      <input class="form-control" name="file" type="file" accept=".jpg, .png, .jpeg">
                                    </div>
                                    <div class="form-group">
                                      <label>Isi Berita</label>
                                      <textarea class="form-control" name="isi" placeholder="Masukkan isi berita" rows="5"></textarea>
                                    </div>
                                  <input type="submit" class="btn btn-success" name="simpan" value="Simpan">
                                </form>
                            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
  
<!-- ./wrapper -->
<script type="text/javascript">
  $(document).ready(function(){
  $("#cari").on('input change', function() {
    var search = $('#cari').val();
    var hastag = $('#hastag').val();
    var kategori = $('#kategori').val(); // Mengambil nilai dari input id_kategori
    
    $.ajax({
      url: '../../ajax/ad_searchNews.php',
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
<?php include('../footer.php')?>
<!-- jQuery -->
</body>
</html>
