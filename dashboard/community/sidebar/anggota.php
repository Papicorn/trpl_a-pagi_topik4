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

if (isset($_POST['edit'])) {
    $status = $_POST['status'];
    $id_user = $koneksi->real_escape_string($_POST['id_user']);
    $nama_komunitas = $data_community['nama_komunitas'];
    
    
        if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user' LIMIT 1")) == 0) {
            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Pengguna tidak terdaftar!', 'pesan' => 'Gagal');
        } else {
            if ($status == "disetujui") {
                if(mysqli_query($koneksi, "UPDATE gabung_community SET status = '$status' WHERE id_user = '$id_user'") == TRUE && mysqli_query($koneksi, "UPDATE user SET id_community = '$id_community' WHERE id_user = '$id_user'") == TRUE && mysqli_query($koneksi, "INSERT INTO aktivitas VALUES ('', 'Bergabung pada komunitas $nama_komunitas', '$id_user', '$today')") == TRUE){
                    $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil mengubah pengguna!', 'pesan' => 'Berhasil');
                } else {
                    $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat menggubah pengguna!', 'pesan' => 'Gagal');
                }
            } elseif ($status == "belum disetujui") {
                if(mysqli_query($koneksi, "UPDATE gabung_community SET status = '$status' WHERE id_user = '$id_user'") == TRUE && mysqli_query($koneksi, "UPDATE user SET id_community = NULL WHERE id_user = '$id_user'") == TRUE){
                    $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil mengubah pengguna!', 'pesan' => 'Berhasil');
                } else {
                    $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat menggubah pengguna!', 'pesan' => 'Gagal');
                }
            }
        }
} else if (isset($_POST['hapus'])) {
    $id_user = $koneksi->real_escape_string($_POST['id_user']);
    if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user' LIMIT 1")) == 0) {
        $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Pengguna tidak terdaftar!', 'pesan' => 'Gagal');
    } else {
        if(mysqli_query($koneksi, "DELETE FROM gabung_community WHERE id_user = '$id_user' AND id_community = '$id_community'") == TRUE){
            if(mysqli_query($koneksi, "UPDATE user SET id_community = NULL WHERE id_user = '$id_user'") == TRUE) {
                $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Pengguna berhasil di hapus dari komunitas!', 'pesan' => 'Berhasil');    
            } else {
                $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Gagal menghapus pengguna!', 'pesan' => 'Gagal');
            }
        } else {
            $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Gagal menghapus pengguna!', 'pesan' => 'Gagal');
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
          <div class="col-12">
            <h1 class="m-0 text-dark">Anggota</h1>
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
                    <th>Kelamin</th>
                    <th>Status</th>
                    <th>Tgl Bergabung</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="list-anggota">
                    <?php 
                        $jumlahDataPerhalaman = 10;
                        $jumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM gabung_community WHERE id_community = '$id_community'"));
                        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
                        $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
                        $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
                    
                        $no = 1;
                        $cek_Gcommunity = mysqli_query($koneksi, "SELECT * FROM gabung_community WHERE id_community = '$id_community' ORDER BY tgl_gabung DESC LIMIT $awalData, $jumlahDataPerhalaman");
                        while ($row = mysqli_fetch_assoc($cek_Gcommunity)) {
                            $id_user = $row['id_user'];
                            
                            $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
                            $data_user = mysqli_fetch_assoc($cek_user);
                            
                    ?>
                  <tr>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id_user=<?= $row['id_user'] ?>" method="POST">
                        <input type="text" name="id_user" value="<?= $row['id_user'] ?>" hidden>
                        <td><?= $awalData += 1 ?></td>
                        <td><?= $data_user['username']; ?></td>
                        <td><?= $data_user['nama_lengkap']; ?></td>
                        <td><?= $data_user['kelamin']; ?></td>
                        <td><select name="status" class="form-control" style="min-width: 150px;">
                            <option value="<?= $row['status'] ?>" selected><?= $row['status'] ?></option>
                            <option value="disetujui">Disetujui</option>
                            <option value="belum disetujui">Belum Disetujui</option>
                        </select></td>
                        <td><?= $row['tgl_gabung']; ?></td>
                        <td align="center"><button type="submit" name="edit" class="btn btn-primary btn-sm text-light"><i class="fas fa-edit"></i> Ubah</button>
                        <button type="submit" name="hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
                        <a name="show" href="<?= $weburl ?>/user/profile.php?id_user=<?= $row['id_user'] ?>" class="btn btn-success btn-sm"><i class="fas fa-user"></i> Profile</a>
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

<!-- ./wrapper -->
<?php include('../footer.php')?>
<!-- jQuery -->
</body>
</html>
