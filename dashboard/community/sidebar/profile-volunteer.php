<?php 
session_start();
require '../../../koneksi.php';
require '../../../config.php';

if (!isset($_SESSION['id_community'])) {
    header('Location: ' . $weburl . '/auth/loginkom.php');
    exit();
}
if (!isset($_GET['id_user'])) {
    header('Location: ' . $weburl);
    exit();
}

$id_community = $_SESSION['id_community'];
$id_user = $_GET['id_user'];

// CEK
$cek_settings = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
$cek_community = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community'");
$cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM gabung_kegiatan WHERE id_user = '$id_user'");
$cek_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan WHERE id_user = '$id_user'");
$cek_komentar = mysqli_query($koneksi, "SELECT * FROM komentar WHERE id_user = '$id_user'");

// DATA
$data_settings = mysqli_fetch_assoc($cek_settings);
$data_community = mysqli_fetch_assoc($cek_community);

// JUMLAH
$jumlah_kegiatan = mysqli_num_rows($cek_kegiatan);
$jumlah_ulasan = mysqli_num_rows($cek_ulasan);
$jumlah_komentar = mysqli_num_rows($cek_komentar);

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
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include ('../navbar.php') ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include('../sidebar.php')?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="../../../assets/dist/img/avatar5.png"
                       alt="User profile picture">
                </div>
                <?php
                $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
                $sql = mysqli_fetch_assoc($cek_user);
                ?>
                <h3 class="profile-username text-center"><?php echo $sql['nama_lengkap'] ?></h3>

                <p class="text-muted text-center"><?php if($sql['level'] == "user"){ echo "Sukarelawan"; } else { echo "Admin";} ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Kegiatan Diikuti</b> <a class="float-right"><?= $jumlah_kegiatan ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Ulasan Diberikan</b> <a class="float-right"><?= $jumlah_ulasan ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Komentar Diberikan</b> <a class="float-right"><?= $jumlah_komentar ?></a>
                  </li>
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
              
            <?php

            ?>
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tentang Saya</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>

                <p class="text-muted"><?= $sql['alamat'] ?></p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Biodata</strong>

                <p class="text-muted"><?= $sql['biodata'] ?></p>
                
                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Komunitas</strong>

                <p class="text-muted"><?php 
                    if($sql['id_community'] == NULL) {
                        echo "-";
                    } else {
                        $id_cm = $sql['id_community'];
                        $komu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_cm'"));
                        echo $komu['nama_komunitas'];
                    }
                ?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <h4 class="mb-0">Aktivitas</h4>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane border-bottom">
                    <!-- Post -->

                    <?php
                    $cek_aktivitas = mysqli_query($koneksi, "SELECT * FROM aktivitas WHERE id_user = '$id_user' ORDER BY waktu DESC LIMIT 5");
                    
                    while ($sql1 = mysqli_fetch_assoc($cek_aktivitas)) {
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <p><i class="fas fa-circle text-muted"></i>  <b class="text-primary"><?= $sql['nama_lengkap'] ?></b> <b class="text-muted"><?= $sql1['aktivitas'] ?></b> <b class="text-warning"><?= $sql1['waktu'] ?></b></p>    
                        </div>
                    </div>
                    <!-- /.post -->
                    <?php } ?>


                  <!-- /.tab-pane -->


                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
              <h5 class="mt-3">
                Kegiatan & Ulasan        
              </h5>
              <div class="row">
                        <div class="col-12">
                            <table class="table table-striped table-hover table-bordered">
                                <tr>
                                   <th>No</th> 
                                   <th>Nama Kegiatan</th>
                                   <th>Ulasan</th>
                                   <th>Waktu ulasan</th>
                                   <th>Waktu kegiatan</th>
                                </tr>
              <?php
                    $cek_gabungK = mysqli_query($koneksi, "SELECT * FROM gabung_kegiatan WHERE id_user = '$id_user' ORDER BY waktu_bergabung DESC LIMIT 5");
                    
                    $no = 1;
                    while ($sql2 = mysqli_fetch_assoc($cek_gabungK)) {
                        $id_kegiatan = $sql2['id_kegiatan'];
                        
                        $data_kgtn = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'"));
                        $data_ulsn = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM ulasan WHERE id_kegiatan = '$id_kegiatan' AND id_user = '$id_user'"));
                    ?>

                    
                                <tr onclick="window.location.href='<?= $weburl ?>/kegiatan/kegiatan.php?id_kegiatan=<?= $id_kegiatan ?>'" style="cursor: pointer;">
                                    <td><?= $no++ ?></td>
                                    <td><?= $data_kgtn['judul_kegiatan'] ?></td>
                                    <td><textarea class="form-control" rows="3" disabled><?= $data_ulsn['ulasan'] ?></textarea></td>
                                    <td><?= $data_ulsn['tgl_ulasan'] ?></td>
                                    <td><?= $sql2['waktu_bergabung'] ?></td>
                                </tr>
                    
                    <?php } ?>
                    
                            </table>
                        </div>
                    </div>
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  
<?php include('../footer.php')?>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</body>
</html>
