<?php 
session_start();
require '../../../koneksi.php';
require '../../../config.php';

if (!isset($_SESSION['id_community'])) {
    header('Location: ' . $weburl . '/auth/loginkom.php');
    exit();
}
if(!isset($_GET['id_kegiatan'])) {
    header('Location: kegiatan.php');
} else {
    $id_community = $_SESSION['id_community'];
    $id_kegiatan = $_GET['id_kegiatan'];
    
    $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
    $data_kegiatan = mysqli_fetch_assoc($cek_kegiatan);
    
    $cek_settings = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
    $cek_community = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community'");
    $data_settings = mysqli_fetch_assoc($cek_settings);
    $data_community = mysqli_fetch_assoc($cek_community);
    
    if(isset($_POST['hapus'])) {
        $id_user = $_GET['id_user'];
        if(mysqli_query($koneksi, "DELETE FROM gabung_kegiatan WHERE id_user = '$id_user'") == TRUE) {
            $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil menghapus pengguna yang tergabung ke kegiatan!', 'pesan' => 'Berhasil');
        } else {
            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat menghapus pengguna!', 'pesan' => 'Gagal');
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
          <div class="col-9">
            <h1 class="m-0 text-dark">Pengguna Tergabung</h1>
          </div><!-- /.col -->
          <div class="col-3 d-flex justify-content-end">
                  <div class="input-group input-group-sm col-12 pr-0 d-flex justify-content-end">
                      <a href="kegiatan.php" class="btn btn-success"><i class="fas fa-arrow-left"></i> Kembali</a>
                  </div>
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
                <div class="d-flex justify-content-center">
                    <h4 class="mb-0">Judul : <?= $data_kegiatan['judul_kegiatan'] ?></h4>
                </div>
            </div>
          </div>
        </section>

        <?php 
        $jumlahDataPerhalaman = 9;
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
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Komunitas</th>
                    <th>Kelamin</th>
                    <th>Tanggal Bergabung</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $jumlahDataPerhalaman = 10;
                        $jumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM gabung_kegiatan WHERE id_kegiatan = '$id_kegiatan'"));
                        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
                        $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
                        $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
                    
                        $no = 1;
                        $cek_kegiatan1 = mysqli_query($koneksi, "SELECT * FROM gabung_kegiatan WHERE id_kegiatan = '$id_kegiatan' ORDER BY waktu_bergabung DESC LIMIT $awalData, $jumlahDataPerhalaman");
                        while ($row = mysqli_fetch_assoc($cek_kegiatan1)) {
                            $id_user = $row['id_user'];
                            
                            $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
                            $data_user = mysqli_fetch_assoc($cek_user);
                            $id_com = $data_user['id_community'];
                            
                            $cek_com = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_com'");
                            $data_com = mysqli_fetch_assoc($cek_com);
                            
                            $tgl_bergabung = date('d M Y', strtotime($row['waktu_bergabung']));
                            
                            $komunitas = $data_com['nama_komunitas'];
                            if(!isset($komunitas)) {
                                $komunitas = "-";
                            }
                            
                    ?>
                  <tr>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id_kegiatan=<?= $id_kegiatan; ?>&id_user=<?= $row['id_user'] ?>" method="POST">
                    <td><?= $awalData += 1 ?></td>
                    <td><?= $data_user['username']; ?></td>
                    <td><?= $data_user['nama_lengkap']; ?></td>
                    <td><?= $komunitas; ?></td>
                    <td><?= $data_user['kelamin']; ?></td>
                    <td><?= $tgl_bergabung; ?></td>
                    <td align="center"><a name="show" href="<?= $weburl ?>/dashboard/community/sidebar/profile-volunteer.php?id_user=<?= $id_user ?>" class="btn btn-success btn-sm"><i class="fas fa-user"></i> Profile</a>
                    <button type="submit" name="hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
                    </td>
                    </form>
                  </tr>
                  
                      
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
                  <input type="text" name="judul" class="form-control" placeholder="Masukkan judul">
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select class="form-control" name="kategori">
                      <option value="" selected disabled>-- Kategori --</option>
                      <option value="Sosialisasi">Sosialisasi</option>
                      <option value="Gotong Royong">Gotong Royong</option>
                  </select>
                </div>
              <div class="form-group">
                  <label>Lokasi</label>
                  <input type="text" name="lokasi" class="form-control" placeholder="Tambahkan Lokasi">
              </div>
              <div class="form-group">
                  <label>Waktu Dimulai</label>
                  <input type="datetime-local" name="waktu_mulai" class="form-control">
              </div>
              <div class="form-group">
                  <label>Waktu Selesai</label>
                  <input type="datetime-local" name="waktu_selesai" class="form-control">
              </div>
              <div class="form-group">
                  <label>Tambahkan Banner</label>
                  <input class="form-control" name="file" type="file" accept=".jpg, .png, .jpeg">
              </div>
                <div class="form-group">
                  <label>Isi Kegiatan</label>
                  <textarea class="form-control" name="isi" placeholder="Masukkan isi kegiatan" rows="5"></textarea>
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
  $("#kategori").on('input change', function() {
    var id_kegiatan = "<?= $id_kegiatan ?>";
    var search = $('#cari').val();
    var kategori = $('#kategori').val(); // Mengambil nilai dari input id_kategori
    
    $.ajax({
      url: '../../ajax/km_penggunaTergbabung.php',
      data: { search: search, kategori: kategori, id_kegiatan: id_kegiatan }, // Menggunakan objek untuk data
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
