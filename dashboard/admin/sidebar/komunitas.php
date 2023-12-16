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

// CEK
$cek_settings = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
$cek_community = mysqli_query($koneksi, "SELECT * FROM community");
$cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan");

// DATA
$data_settings = mysqli_fetch_assoc($cek_settings);
$data_community = mysqli_fetch_assoc($cek_community);

// JUMLAH
$jumlah_kegiatan = mysqli_num_rows($cek_kegiatan);

$targetDirectory = "../../../assets/img/kegiatan/";

if (isset($_POST['edit'])) {
    $status = $_POST['status'];
    $id_community = $koneksi->real_escape_string($_POST['id_community']);
    
        if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community' LIMIT 1")) == 0) {
            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Komunitas tidak terdaftar!', 'pesan' => 'Gagal');
        } else {
                if(mysqli_query($koneksi, "UPDATE community SET status = '$status' WHERE id_community = '$id_community'") == TRUE){
                    $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil mengubah komunitas!', 'pesan' => 'Berhasil');
                } else {
                    $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat menggubah pengguna!', 'pesan' => 'Gagal');
                }
        }
} else if (isset($_POST['hapus'])) {
    $id_community = $koneksi->real_escape_string($_POST['id_community']);
    $banner = $koneksi->real_escape_string($_GET['banner']);
    $sertifikat = $koneksi->real_escape_string($_GET['sertifikat']);
    
    $lokasi_fileS = '../../../uploads/sertifikat/' . $sertifikat;
    $lokasi_fileB = '../../../assets/img/komunitas-profile/' . $banner;
    
    if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community' LIMIT 1")) == 0) {
        $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Komunitas tidak terdaftar!', 'pesan' => 'Gagal');
    } else {
        if(mysqli_query($koneksi, "DELETE FROM community WHERE id_community = '$id_community'") == TRUE){
            if(file_exists($lokasi_fileS) == TRUE && file_exists($lokasi_fileB) == TRUE) {
                unlink($lokasi_fileS);
                unlink($lokasi_fileB);
            }
            $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Komunitas berhasil di hapus!', 'pesan' => 'Berhasil');    
        } else {
            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Gagal menghapus komunitas!', 'pesan' => 'Gagal');
        }
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
          <div class="col-5">
            <h1 class="m-0 text-dark">Komunitas</h1>
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
            
          </div>
        </section>

        <section class="content">
          <div class="row">
        <div class="col-12" id="list-komunitas">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover table-bordered text-nowrap">
                <thead class="bg-warning">
                  <tr>
                    <th>No</th>
                    <th>Nama Komunitas</th>
                    <th>Pemilik</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Tgl Bergabung</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $jumlahDataPerhalaman = 10;
                        $jumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM community"));
                        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
                        $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
                        $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
                    
                        $no = 1;
                        $cek_Community = mysqli_query($koneksi, "SELECT * FROM community ORDER BY tgl_bergabung DESC LIMIT $awalData, $jumlahDataPerhalaman");
                        
                        while ($row = mysqli_fetch_assoc($cek_Community)) {
                            $id_user = $row['id_user'];
                            
                            $cek_user1 = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
                            $data_user1 = mysqli_fetch_assoc($cek_user1);
                            
                    ?>
                  <tr>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id_community=<?= $row['id_community'] ?>&banner=<?= $row['profile_picture'] ?>&sertifikat=<?= $row['sertifikat'] ?>" method="POST">
                        <input type="text" name="id_community" value="<?= $row['id_community'] ?>" hidden>
                        <td><?= $awalData += 1 ?></td>
                        <td><?= $row['nama_komunitas']; ?></td>
                        <td><?= $data_user1['nama_lengkap']; ?></td>
                        <td style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-width: 25rem;"><?= $row['deskripsi']; ?></td>
                        <td><select name="status" class="form-control" style="min-width: 150px;" >
                            <option value="<?= $row['status'] ?>" selected="" class="text-capitalize"><?= $row['status'] ?></option>
                            <option value="disetujui">Disetujui</option>
                            <option value="belum disetujui">Belum Disetujui</option>
                        </select></td>
                        <td><?= $row['tgl_bergabung']; ?></td>
                        <td align="center"><button type="submit" name="edit" class="btn btn-primary btn-sm text-light"><i class="fas fa-edit"></i> Ubah</button>
                        <button type="submit" name="hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
                        <a name="show" href="javascript:;" class="btn btn-success btn-sm" data-toggle="modal" data-target="#detail<?= $row['id_community'] ?>"><i class="fas fa-info-circle"></i> Detail</a>
                        </td>
                    </form>
                  </tr>
                  <!-- Modal Ubah kegiatan -->
                      <div class="modal fade" id="detail<?= $row['id_community'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-warning text text-light">
                              <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Detail Komunitas</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Komunitas</label><br>
                                    <?= $row['nama_komunitas']; ?>
                                </div><hr>
                                <div class="form-group">
                                    <label>Deskripsi</label><br>
                                    <?= $row['deskripsi']; ?>
                                </div><hr>
                                <div class="form-group">
                                    <label>Pemilik</label><br>
                                    <?= $data_user1['nama_lengkap']; ?>
                                </div><hr>
                                <div class="form-group">
                                    <label>No Telpon</label><br>
                                    <?= $row['no_telpon']; ?>
                                </div><hr>
                                <div class="form-group">
                                    <label>Email</label><br>
                                    <?= $row['email']; ?>
                                </div><hr>
                                <div class="form-group">
                                    <label>Foto Profile</label><br>
                                    <img src="../../../assets/img/komunitas-profile/<?= $row['profile_picture'] ?>" class="w-25 border">
                                </div><hr>
                                <div class="form-group">
                                    <label>Sertifikat</label><br>
                                    <a href="../../../uploads/sertifikat/<?= $row['sertifikat'] ?>">Lihat Sertifikat disini</a>
                                </div><hr>
                                <div class="form-group">
                                    <label>Status</label><br>
                                    <?= $row['status'] ?>
                                </div><hr>
                                <div class="form-group">
                                    <label>Tanggal Bergabung</label><br>
                                    <?= $row['tgl_bergabung'] ?>
                                </div><hr>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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
  <div class="modal fade" id="tambahAnggota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" placeholder="Masukkan username">
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
  
 <script type="text/javascript">
  $(document).ready(function(){
  $("#cari").on('input change', function() {
    var search = $('#cari').val();
    var kategori = $('#kategori').val(); // Mengambil nilai dari input id_kategori
    
    $.ajax({
      url: '../../ajax/ad_searchKomunitas.php',
      data: { search: search, kategori: kategori }, // Menggunakan objek untuk data
      type: 'POST',
      dataType: 'html',
      success: function(data) {
        $("#list-komunitas").html(data); // Mengubah nilai input teks #isi
      },
      error: function(xhr, status, error) {
        console.error(error); // Menampilkan pesan error di konsol
      }
    });
  });
  
  $('#kategori').on('change', function() {
    var search = $('#cari').val();
    var kategori = $(this).val(); // Mengambil nilai dari input #kategori

    $.ajax({
      url: '../../ajax/ad_searchKomunitas.php',
      data: { search: search, kategori: kategori },
      type: 'POST',
      dataType: 'html',
      success: function(data) {
        $("#list-komunitas").html(data);
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });
});

</script>

<!-- ./wrapper -->
<?php include('../footer.php')?>
<!-- jQuery -->
</body>
</html>
