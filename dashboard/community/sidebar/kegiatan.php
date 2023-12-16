<?php 
session_start();
require '../../../koneksi.php';
require '../../../config.php';

if (!isset($_SESSION['id_community'])) {
    header('Location: ' . $weburl . '/auth/loginkom.php');
    exit();
}

$id_community = $_SESSION['id_community'];

// CEK
$cek_settings = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
$cek_community = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community'");
$cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_community = '$id_community'");

// DATA
$data_settings = mysqli_fetch_assoc($cek_settings);
$data_community = mysqli_fetch_assoc($cek_community);

// JUMLAH
$jumlah_kegiatan = mysqli_num_rows($cek_kegiatan);

$targetDirectory = "../../../assets/img/kegiatan/";

$cari_email = mysqli_query($koneksi, "SELECT email,username,nama_lengkap FROM user");

if (isset($_POST['simpan1'])) {
    $judul = $koneksi->real_escape_string($_POST['judul']);
    $kategori = $koneksi->real_escape_string($_POST['kategori']);
    $lokasi = $koneksi->real_escape_string($_POST['lokasi']);
    $waktu_mulai = $koneksi->real_escape_string($_POST['waktu_mulai']);
    $waktu_selesai = $koneksi->real_escape_string($_POST['waktu_selesai']);
    $isi = $koneksi->real_escape_string($_POST['isi']);
    
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $banner = basename($_FILES["file"]["name"]);
    
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    
    $waktu_mulai = strtotime($waktu_mulai);
    $tgl_mulai = date('Y-m-d', $waktu_mulai);
    $mulai = date('H:i:s', $waktu_mulai);
    
    $waktu_selesai = strtotime($waktu_selesai);
    $tgl_selesai = date('Y-m-d', $waktu_selesai);
    $selesai = date('H:i:s', $waktu_selesai);
    
    if ($_FILES["file"]["size"] > 1000000) {
        $uploadOk = 0;
    }
    
    // Hanya izinkan format gambar tertentu
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        $uploadOk = 0;
    }
    
    if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
        if (mysqli_query($koneksi, "INSERT INTO `kegiatan` VALUES ('','$judul','$isi','$lokasi','$id_community','$kategori','$banner','$mulai','$selesai','$tgl_mulai','$tgl_selesai','$today')") == TRUE) {
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)){
                require '../../../send_mail.php';
                $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Yey anda berhasil membuat kegiatan baru!', 'pesan' => 'Berhasil');
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
        $id_kegiatan = $_GET['id_kegiatan'];
        $file_name = $_GET['banner'];
        $path =  "../../../assets/img/kegiatan/$file_name";
        
        $cek = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
        
        if(mysqli_num_rows($cek) == 0) {
            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Kegiatan tidak tersedia!', 'pesan' => 'Gagal');
        } else {          
            if (mysqli_query($koneksi, "DELETE FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'") == TRUE) {
                unlink($path);
                $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Berhasil menghapus kegiatan yang dipilih!', 'pesan' => 'Berhasil');
            } else {
                $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Gagal menghapus kegiatan yang dipilih!', 'pesan' => 'Gagal');
            }
        }
    } else if (isset($_POST['ubah'])) {
        $id_kegiatan = $koneksi->real_escape_string($_POST['id_kegiatan']);
        
        $judul = $koneksi->real_escape_string($_POST['judul']);
        $kategori = $koneksi->real_escape_string($_POST['kategori']);
        $lokasi = $koneksi->real_escape_string($_POST['lokasi']);
        $waktu_mulai = $koneksi->real_escape_string($_POST['waktu_mulai']);
        $waktu_selesai = $koneksi->real_escape_string($_POST['waktu_selesai']);
        $isi = $koneksi->real_escape_string($_POST['isi']);
        $banner = $koneksi->real_escape_string($_POST['banner']);
        
        $waktu_mulai = strtotime($waktu_mulai);
        $tgl_mulai = date('Y-m-d', $waktu_mulai);
        $mulai = date('H:i:s', $waktu_mulai);
        
        $waktu_selesai = strtotime($waktu_selesai);
        $tgl_selesai = date('Y-m-d', $waktu_selesai);
        $selesai = date('H:i:s', $waktu_selesai);
        
        if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
            $path =  "../../../assets/img/kegiatan/$banner";
            unlink($path);
            
            $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
            $banner = basename($_FILES["file"]["name"]);
            
            $check = getimagesize($_FILES["file"]["tmp_name"]);
        }
        
        if (mysqli_query($koneksi, "UPDATE `kegiatan` SET `judul_kegiatan`='$judul',`isi_kegiatan`='$isi',`lokasi`='$lokasi',`kategori`='$kategori',`banner`='$banner',`waktu_mulai`='$mulai',`waktu_selesai`='$selesai',`tgl_mulai`='$tgl_mulai',`tgl_selesai`='$tgl_selesai' WHERE id_kegiatan = '$id_kegiatan'") == TRUE){
            if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
                move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
            }
            $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil mengubah detail kegiatan! ', 'pesan' => 'Berhasil');
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
            <h1 class="m-0 text-dark">Kegiatan</h1>
          </div><!-- /.col -->
          <div class="col-7 d-flex justify-content-end">
              <form class="form-inline col-md-8 col-sm-12 pr-0">
                  <div class="input-group input-group-sm col-12 pr-0">
                      <select class="form-select mr-1 border" id="kategori" aria-label="Kategori" style="width: 70px;">
                                <option value="" selected="" disabled="">Filter</option>
                                <option value="kategori">Kategori</option>
                                <option value="judul">Judul</option>
                            </select>
                    <input class="form-control form-control-navbar" id="cari" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                      <button class="btn btn-secondary" type="submit" id="submit">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
          </div>
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
                    <a class="btn btn-success text-light" data-toggle="modal" data-target="#tambahKegiatan">
                      <i class="fas fa-plus"></i>  Tambah Kegiatan
                    </a>
                </div>
            </div>
          </div>
        </section>

        <?php 
        $jumlahDataPerhalaman = 10;
        $jumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_community = '$id_community'"));
        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
        $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
        $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman; 
        ?>
        <section class="content">
          <div class="row">
        <div class="col-12" id="list-kegiatan">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover table-bordered text-nowrap">
                <thead class="bg-warning">
                  <tr>
                    <th>No</th>
                    <th>Judul Kegiatan</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tergabung</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $jumlahDataPerhalaman = 10;
                        $jumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_community = '$id_community'"));
                        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
                        $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
                        $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
                    
                        $no = 1;
                        $cek_kegiatan1 = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_community = '$id_community' ORDER BY tgl_dibuat DESC LIMIT $awalData, $jumlahDataPerhalaman");
                        while ($row = mysqli_fetch_assoc($cek_kegiatan1)) {
                            
                            $today = $tanggal . " " . $time;
                            
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
                            
                            $tgl_dibuat = date('d M Y', strtotime($row['tgl_dibuat']));
                            
                            $idKegiatan = $row['id_kegiatan'];
                            $cek_gabungK = mysqli_query($koneksi, "SELECT * FROM gabung_kegiatan WHERE id_kegiatan = '$idKegiatan'");
                            $jumlahGabungK = mysqli_num_rows($cek_gabungK);
                            
                    ?>
                  <tr>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id_kegiatan=<?= $row['id_kegiatan'] ?>&banner=<?= $row['banner'] ?>" method="POST">
                    <td><?= $awalData += 1 ?></td>
                    <td><?= $row['judul_kegiatan']; ?></td>
                    <td><?= $row['kategori']; ?></td>
                    <td><span class="badge badge-<?= $bg; ?>"><?= $status; ?></span></td>
                    <td><?= $jumlahGabungK; ?> <a href="pengguna-tergabung.php?id_kegiatan=<?= $row['id_kegiatan']; ?>" class="text-muted font-weight-normal pe-auto" style="font-size: 14px;">(Lihat)</a></td>
                    <td><?= $tgl_dibuat; ?></td>
                    <td align="center"><a name="edit" class="btn btn-primary btn-sm text-light" data-toggle="modal" data-target="#ubahKegiatan<?= $row['id_kegiatan'] ?>"><i class="fas fa-edit"></i> Ubah</a>
                    <button type="submit" name="hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
                    <a name="show" href="<?= $weburl ?>/kegiatan/kegiatan.php?id_kegiatan=<?= $row['id_kegiatan'] ?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Lihat</a>
                    </td>
                    </form>
                  </tr>
                  
                    <!-- Modal Ubah kegiatan -->
                      <div class="modal fade" id="ubahKegiatan<?= $row['id_kegiatan'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-warning text text-light">
                              <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Ubah Kegiatan</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input style="hidden" value="<?= $row['id_kegiatan'] ?>" name="id_kegiatan" hidden> 
                                    <input style="hidden" value="<?= $row['banner'] ?>" name="banner" hidden> 
                                    <div class="form-group">
                                      <label>Judul Kegiatan</label>
                                      <input type="text" name="judul" class="form-control" placeholder="Masukkan judul" value="<?= $row['judul_kegiatan']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Kategori</label>
                                      <select class="form-control" name="kategori">
                                          <option value="<?= $row['kategori'] ?>" selected><?= $row['kategori'] ?></option>
                                          <option value="Sosialisasi">Sosialisasi</option>
                                          <option value="Gotong Royong">Gotong Royong</option>
                                      </select>
                                    </div>
                                  <div class="form-group">
                                      <label>Lokasi</label>
                                      <input type="text" name="lokasi" class="form-control" value="<?= $row['lokasi'] ?>" placeholder="Tambahkan Lokasi">
                                  </div>
                                  <div class="form-group">
                                      <label>Waktu Dimulai</label>
                                      <input type="datetime-local" name="waktu_mulai" class="form-control" value="<?= $mulai ?>">
                                  </div>
                                  <div class="form-group">
                                      <label>Waktu Selesai</label>
                                      <input type="datetime-local" name="waktu_selesai" class="form-control" value="<?= $selesai ?>">
                                  </div>
                                  <div class="form-group">
                                      <label>Tambahkan Banner <small>(16:9)</small></label>
                                      <input class="form-control" name="file" type="file" accept=".jpg, .png, .jpeg">
                                  </div>
                                    <div class="form-group">
                                      <label>Isi Kegiatan</label>
                                      <textarea class="form-control" name="isi" placeholder="Masukkan isi kegiatan" rows="5"><?= $row['isi_kegiatan'] ?></textarea>
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

 <!-- Modal Tambah kegiatan -->
  <div class="modal fade" id="tambahKegiatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning text text-light">
          <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Kegiatan Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Judul Kegiatan</label>
                  <input type="text" name="judul" class="form-control" placeholder="Masukkan judul" required>
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select class="form-control" name="kategori" required>
                      <option value="" selected disabled>-- Kategori --</option>
                      <option value="Sosialisasi">Sosialisasi</option>
                      <option value="Gotong Royong">Gotong Royong</option>
                  </select>
                </div>
              <div class="form-group">
                  <label>Lokasi</label>
                  <input type="text" name="lokasi" class="form-control" placeholder="Tambahkan Lokasi" required>
              </div>
              <div class="form-group">
                  <label>Waktu Dimulai</label>
                  <input type="datetime-local" name="waktu_mulai" class="form-control" required>
              </div>
              <div class="form-group">
                  <label>Waktu Selesai</label>
                  <input type="datetime-local" name="waktu_selesai" class="form-control" required>
              </div>
              <div class="form-group">
                  <label>Tambahkan Banner <small>(16:9)</small></label>
                  <input class="form-control" name="file" type="file" accept=".jpg, .png, .jpeg" required>
              </div>
                <div class="form-group">
                  <label>Isi Kegiatan</label>
                  <textarea class="form-control" name="isi" placeholder="Masukkan isi kegiatan" rows="5" required></textarea>
              </div>
              <input type="submit" class="btn btn-success" name="simpan1" value="Simpan">
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
    var kategori = $('#kategori').val(); // Mengambil nilai dari input id_kategori
    
    $.ajax({
      url: '../../ajax/km_searchKegiatan.php',
      data: { search: search, kategori: kategori }, // Menggunakan objek untuk data
      type: 'POST',
      dataType: 'html',
      success: function(data) {
        $("#list-kegiatan").html(data); // Mengubah nilai input teks #isi
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
