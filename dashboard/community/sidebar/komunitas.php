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

$pemilik = $data_user['nama_lengkap'];

if (isset($_POST['kirim'])) {
    $deskripsi = $koneksi->real_escape_string($_POST['deskripsi']);
    $notelp = $koneksi->real_escape_string($_POST['notelp']);
    $email = $koneksi->real_escape_string($_POST['email']);
    
    if(mysqli_query($koneksi, "UPDATE community SET deskripsi = '$deskripsi', no_telpon = '$notelp', email = '$email' WHERE id_community = '$id_community'") == TRUE){
        $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil!', 'pesan' => 'Gagal');
    } else {
        $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Gagal memperbarui data!', 'pesan' => 'Gagal');
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
            <h1 class="m-0 text-dark">Kelola Komunitas</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Form -->
                        <?php 
                            $cek_community1 = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community'");
                            $data_community1 = mysqli_fetch_assoc($cek_community1);
                                                    
                            $id_user = $data_community['id_user'];
                            
                            $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
                            $data_user = mysqli_fetch_assoc($cek_user);

                            $pemilik = $data_user['nama_lengkap'];

                        ?>
                        <form method="POST">
                            <!-- Isi formulir Anda di sini -->
                            <div class="form-group">
                                <label for="nama_komunitas">Nama Komunitas</label>
                                <input type="text" class="form-control" id="nama_komunitas" placeholder="Masukkan nama" disabled required value="<?= $data_community1['nama_komunitas'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2" required placeholder="Masukkan deskripsi"><?= $data_community1['deskripsi'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="pemilik">Pemilik</label>
                                <input type="text" class="form-control" name="pemilik" id="pemilik" required placeholder="Masukkan nama" disabled value="<?= $pemilik; ?>">
                            </div>
                            <div class="form-group">
                                <label for="notelp">No Telp</label>
                                <input type="number" class="form-control" name="notelp" id="notelp" required placeholder="Masukkan notelp" value="<?= $data_community1['no_telpon'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="notelp">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required placeholder="Masukkan email" value="<?= $data_community1['email'] ?>">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" name="kirim" class="btn btn-success">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
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


<!-- ./wrapper -->
<?php include('../footer.php')?>
<!-- jQuery -->
</body>
</html>
