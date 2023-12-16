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
    
    $id_user = $data_user['id_user'];
        
    
// CEK
$cek_settings = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");


// DATA
$data_settings = mysqli_fetch_assoc($cek_settings);

if (isset($_POST['simpan'])) {
    $notelp = $koneksi->real_escape_string($_POST['notelp']);
    $email = $koneksi->real_escape_string($_POST['email']);
    $nama_lengkap = $koneksi->real_escape_string($_POST['nama_lengkap']);
    $kelamin = $koneksi->real_escape_string($_POST['kelamin']);
    $alamat = $koneksi->real_escape_string($_POST['alamat']);
    $biodata = $koneksi->real_escape_string($_POST['biodata']);
    
    if(mysqli_query($koneksi, "UPDATE user SET no_telpon = '$notelp', email = '$email', nama_lengkap = '$nama_lengkap', kelamin = '$kelamin', biodata = '$biodata' WHERE id_user = '$id_user'") == TRUE){
        $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil memperbarui profile!', 'pesan' => 'Berhasil');
    } else {
        $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat pemrosesan, coba lagi!', 'pesan' => 'Gagal');
    }
}

$cek_user1 = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
$data_user1 = mysqli_fetch_assoc($cek_user1);
    
$id_community = $data_user['id_community'];

$cek_community = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community'");
$data_community = mysqli_fetch_assoc($cek_community);

if(!$data_user['id_community']) {
    $komunitas = "-";
} else {
    $komunitas = $data_community['nama_komunitas'];
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
            <h1 class="m-0 text-dark">Pengaturan Profile</h1>
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
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_pengguna">Nama Pengguna</label>
                                        <input type="text" class="form-control" id="nama_pengguna" placeholder="Username Anda" disabled required value="<?= $data_user1['username'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" required placeholder="Masukkan Email" value="<?= $data_user1['email']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="kelamin">Kelamin</label><br>
                                        <input type="radio" name="kelamin" value="pria" id="pria" <?= ($data_user1['kelamin'] == 'pria') ? 'checked' : '' ?>>
                                        <label for="pria" class="mr-1">Pria</label>
                                        <input type="radio" name="kelamin" value="wanita" id="wanita" <?= ($data_user1['kelamin'] == 'wanita') ? 'checked' : '' ?>>
                                        <label for="wanita">Wanita</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="biodata">Biodata</label>
                                        <textarea class="form-control" id="biodata" name="biodata" required placeholder="Masukkan Biodata"><?= $data_user1['biodata']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" required placeholder="Masukkan Alamat Anda"><?= $data_user1['alamat']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" rows="2" required placeholder="Masukkan Nama Lengkap" value="<?= $data_user1['nama_lengkap'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="notelp">No Telpon</label>
                                        <input type="number" class="form-control" name="notelp" id="notelp" required placeholder="Masukkan No Telpon" value="<?= $data_user1['no_telpon'] ?>" maxlength='13'>
                                    </div>
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input type="text" class="form-control" id="nik" required placeholder="NIK Anda" disabled value="<?= $data_user1['nik']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="komunitas">Komunitas</label>
                                        <input type="text" class="form-control" id="komunitas" required placeholder="Komunitas Anda" disabled value="<?= $komunitas; ?>">
                                    </div>
                                </div>
                            </div>
                            
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('[maxlength]').forEach(input => {
        input.addEventListener('input', e => {
        let val = e.target.value, len = +e.target.getAttribute('maxlength');
          e.target.value = val.slice(0,len);
        })
      })
    })
</script>
<!-- ./wrapper -->
<?php include('../footer.php')?>
<!-- jQuery -->
</body>
</html>
