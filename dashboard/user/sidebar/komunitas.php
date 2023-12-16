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
$cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan");

// DATA
$data_settings = mysqli_fetch_assoc($cek_settings);

// JUMLAH
$jumlah_kegiatan = mysqli_num_rows($cek_kegiatan);

if(isset($_POST['gabung'])) {
    $id_community = $koneksi->real_escape_string($_POST['id_community']);
    
    $cekUser = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
    $dataUser = mysqli_fetch_assoc($cekUser); 
    
    $cek_com = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community' LIMIT 1");
    $data_com = mysqli_fetch_assoc($cek_com);
    
    $nama_komunitas = $data_com['nama_komunitas'];
    
    if(mysqli_num_rows($cek_com) == 0) {
        $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Komunitas tidak tersedia!', 'pesan' => 'Gagal');
    } else {
        if(isset($dataUser['id_community'])) {
             $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Anda telah bergabung ke komunitas sebelumnya, harap hubungi admin ataupun komunitas terkait!', 'pesan' => 'Gagal');
        } else {
            if(mysqli_query($koneksi, "INSERT INTO gabung_community VALUES ('', '$id_user', '$id_community', 'belum disetujui', '$tanggal')") == TRUE) {
                $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil meminta untuk bergabung', 'pesan' => 'Berhasil');
            } else {
                $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat menambaahkan pengguna!', 'pesan' => 'Gagal');
            }
        }
    }
} else if (isset($_POST['keluar'])) {
    $id_community = $koneksi->real_escape_string($_POST['id_community']);
    
    $cek_com = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community' LIMIT 1");
    $data_com = mysqli_fetch_assoc($cek_com);
    
    $nama_komunitas = $data_com['nama_komunitas'];
    
    if (mysqli_query($koneksi, "DELETE FROM gabung_community WHERE id_user = '$id_user' AND id_community = '$id_community'") == TRUE && mysqli_query($koneksi, "UPDATE user SET id_community = NULL WHERE id_user = '$id_user'") == TRUE  && mysqli_query($koneksi, "INSERT INTO aktivitas VALUES ('', 'Keluar dari komunitas $nama_komunitas', '$id_user', '$today')") == TRUE) {
        $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda berhasil keluar komunitas', 'pesan' => 'Berhasil');
    } else {
        $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat melakukan proses, coba lagi!', 'pesan' => 'Gagal');
    }
} else if (isset($_POST['batal'])) {
    $id_community = $koneksi->real_escape_string($_POST['id_community']);
    
    if (mysqli_query($koneksi, "DELETE FROM gabung_community WHERE id_user = '$id_user' AND id_community = '$id_community'") == TRUE) {
        $_SESSION['alert'] = array('alert' => 'success', 'judul' => 'Anda telah membatalkan permintaan untuk bergabung!', 'pesan' => 'Berhasil');
    } else {
        $_SESSION['alert'] = array('alert' => 'danger', 'judul' => 'Ada kesalahan saat melakukan proses, coba lagi!', 'pesan' => 'Gagal');
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
            <h1 class="m-0 text-dark">Komunitas</h1>
          </div><!-- /.col -->
          <?php 
                $cek_gbgK = mysqli_query($koneksi, "SELECT * FROM gabung_community WHERE id_user = '$id_user'");
                $data_gbk = mysqli_fetch_assoc($cek_gbgK);
                
            if(mysqli_num_rows($cek_gbgK) == 0) {
          ?>
              <div class="col-7 d-flex justify-content-end">
                  <form class="form-inline col-md-8 col-sm-12 pr-0">
                      <div class="input-group input-group-sm col-12 pr-0">
                        <input class="form-control form-control-navbar" id="cari" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                          <button class="btn btn-secondary" type="submit" id="submit">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </form>
              </div>
            <?php } ?>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- card kegiatan -->
      <div class="content">
        <div class="container-fluid mb-3">
            
            <?php                                                                                                                               
                if (mysqli_num_rows($cek_gbgK) == 0) {
                    
            ?>
            
            <div class="row" id=list-komunitas>
                <?php
                    $jumlahDataPerhalaman = 9;
                    $jumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM community"));
                    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
                    $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
                    $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
                    
                    $cek_community = mysqli_query($koneksi, "SELECT * FROM community WHERE status = 'disetujui' ORDER BY tgl_bergabung DESC LIMIT $awalData, $jumlahDataPerhalaman");
                    while ($row = mysqli_fetch_assoc($cek_community)) {
                        $id_user1 = $row['id_user']; 
                        
                        $cek_user1 = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user1'");
                        $data_user1 = mysqli_fetch_assoc($cek_user1);
                        
                ?>
                <div class="col-md-4 d-flex">
                    <div class="card border flex-fill">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 border-success border-bottom pb-3">
                                    <img src="<?= $weburl ?>/assets/img/komunitas-profile/<?= $row['profile_picture'] ?>" class="rounded-circle col-12 w-100">
                                </div>
                                <div class="col-7 border-success border-bottom">
                                    <p class="card-text"><b>Nama Komunitas:</b>
                                    <br>
                                    <?= $row['nama_komunitas'] ?>
                                    <br>
                                    <b>Pemilik:</b>
                                    <br>
                                    <?= $data_user1['nama_lengkap'] ?>
                                    <br>
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card-text" style="max-height: 3rem; overflow: hidden;">
                                        <?= $row['deskripsi'] ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer pt-0">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end align-self-end">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalGabung<?= $row['id_community'] ?>"><i class="fas fa-sign-in-alt"></i> Gabung Komunitas</button>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- Modal Gabung -->
                      <div class="modal fade" id="modalGabung<?= $row['id_community'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-warning text text-light">
                              <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Gabung Komunitas</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center p-2 border">
                                    <h5 class="font-weight-bold"><?= $row['nama_komunitas'] ?></h5>
                                    <p><b>Pemilik</b><br>
                                    <?= $data_user1['nama_lengkap'] ?></p>
                                    <p><b>Deskripsi</b><br>
                                    <?= $row['deskripsi'] ?></p>
                                    <p><b>Email</b><br>
                                    <?= $row['email'] ?></p>
                                </div>
                                <p class="mt-2 mb-0">Apakah anda yakin untuk bergabung pada komunitas ini?</p>
                            </div>
                            <div class="modal-footer">
                                <form method="POST">
                                    <input type="hidden" value="<?= $row['id_community'] ?>" name="id_community" hidden> 
                                    <input type="hidden" value="<?= $id_user ?>" name="id_user" hidden> 
                                    
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success" name="gabung">Gabung</button>
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                <?php } ?>
                
            </div>
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
           
           <?php } else if (mysqli_num_rows($cek_gbgK) != 0 && $data_user['id_community'] == NULL) {
               $id_community1 = $data_gbk['id_community'];
               $kom = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community1'");
               $kom1 = mysqli_fetch_assoc($kom);
               
               $id_user1 = $kom1['id_user'];
               
               $cek_user1 = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user1'");
               $data_user1 = mysqli_fetch_assoc($cek_user1);
               
            ?>
                
                <div class="row d-flex justify-content-center">
                    <div class="col-md-10 col-12">
                       <div class="card border">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-4 col-8 pb-3 text-center">
                                        <img src="<?= $weburl ?>/assets/img/komunitas-profile/<?= $kom1['profile_picture'] ?>" class="rounded-circle col-12 w-75">
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="card-text"><b>Nama Komunitas:</b> <?= $kom1['nama_komunitas'] ?>
                                        <br>
                                        <b>Pemilik:</b> <?= $data_user1['nama_lengkap'] ?>
                                        <br>
                                        <b>Deskripsi:</b> <?= $kom1['deskripsi'] ?>
                                        <br>
                                        <b>Email:</b> <?= $kom1['email'] ?>
                                        <br>
                                        <b>No Telpon:</b> <?= $kom1['no_telpon'] ?>
                                        </p>
                                        <div class="float-md-left float-right">
                                            <form method="POST">
                                                <input name="id_community" type="hidden" value="<?= $id_community1 ?>" hidden>
                                                <button type="submit" class="btn btn-warning" disabled><i class="fas fa-spinner fa-spin"></i> Menunggu Persetujuan</button>
                                                <button type="submit" class="btn btn-danger" name="batal"><i class="fas fa-times"></i> Batalkan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
           <?php } else { 
               $id_community = $data_user['id_community'];
               $cekCom = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community'");
               $dataCom = mysqli_fetch_assoc($cekCom);
               
               $id_pemilik = $dataCom['id_user'];
               $cekUser = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_pemilik'");
               $dataUser = mysqli_fetch_assoc($cekUser);
           ?>
           <div class="row d-flex justify-content-center">
                 <div class="col-md-10 col-12">
                        <div class="card border">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-4 col-8 pb-3 text-center">
                                        <img src="<?= $weburl ?>/assets/img/komunitas-profile/<?= $dataCom['profile_picture'] ?>" class="rounded-circle col-12 w-75">
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <p class="card-text"><b>Nama Komunitas:</b> <?= $dataCom['nama_komunitas'] ?>
                                        <br>
                                        <b>Pemilik:</b> <?= $dataUser['nama_lengkap'] ?>
                                        <br>
                                        <b>Deskripsi:</b> <?= $dataCom['deskripsi'] ?>
                                        <br>
                                        <b>Email:</b> <?= $dataCom['email'] ?>
                                        <br>
                                        <b>No Telpon:</b> <?= $dataCom['no_telpon'] ?>
                                        </p>
                                        <div class="float-md-left float-right">
                                            <button class="btn btn-success"><i class="fas fa-users"></i> Profile</button>
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#keluarCom"><i class="fas fa-sign-out-alt"></i> Keluar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3 pt-2 border-top">
                                    <div class="card-title font-weight-bold">
                                        Kegiatan yang diikuti
                                    </div>
                                </div>
                                <div class="row overflow-auto flex-nowrap" id="scrollContainer">
                                    <?php 
                                        $cek_Gkegiatan1 = mysqli_query($koneksi, "SELECT gabung_kegiatan.id_user, gabung_kegiatan.id_kegiatan, kegiatan.id_kegiatan, kegiatan.id_community FROM gabung_kegiatan LEFT JOIN kegiatan ON gabung_kegiatan.id_kegiatan=kegiatan.id_kegiatan WHERE kegiatan.id_community = '$id_community' AND gabung_kegiatan.id_user = '$id_user'");
                                        while ($data_Gkegiatan1 = mysqli_fetch_assoc($cek_Gkegiatan1)) {
                                            $id_kegiatan = $data_Gkegiatan1['id_kegiatan'];
                                            $cekKeg = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
                                            $datKeg = mysqli_fetch_assoc($cekKeg);
                                            
                                            $selesai = $datKeg['tgl_selesai'] . " " . $datKeg['waktu_selesai'];
                                            $mulai = $datKeg['tgl_mulai'] . " " . $datKeg['waktu_mulai'];
                                            
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
                                    <div class="col-md-6 col-lg-5 col-12 d-flex">
                                      <div class="card flex-fill" onclick="window.location.href='<?= $weburl ?>/kegiatan/kegiatan.php?id_kegiatan=<?= $datKeg['id_kegiatan']; ?>'" style="border-radius: 10px; cursor: pointer;">
                                        <img src="<?= $weburl ?>/assets/img/kegiatan/<?= $datKeg['banner'] ?>" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <div class="card-body">
                                          <label class="text-muted mb-0 font-weight-normal" style="font-style: 13px;">Kategori / <?= $datKeg['kategori'] ?></label><span class="badge badge-<?php echo $bg ?> text-light" style="float: right;"><?php echo $status; ?></span>
                                          <h5 class="card-title" style="font-weight: bold;"><?= $datKeg['judul_kegiatan'] ?></h5>
                                          <div class="card-text" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 1.5rem;" id="beritaD"><?= $datKeg['isi_kegiatan'] ?></div>
                                        </div>
                                      </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Gabung -->
                      <div class="modal fade" id="keluarCom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-warning text text-light">
                              <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Keluar Komunitas</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <p class="mt-2 mb-0">Apakah anda yakin untuk keluar dari <b><?= $dataCom['nama_komunitas'] ?></b> sekarang?</p>
                            </div>
                            <div class="modal-footer">
                                <form method="POST">
                                    <input type="hidden" value="<?= $dataCom['id_community'] ?>" name="id_community" hidden> 
                                    
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger" name="keluar">Keluar</button>
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    
                </div>
           <?php } ?>
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
<script type="text/javascript">
  $(document).ready(function(){
  $("#cari").on('input change', function() {
    var search = $('#cari').val();
    
    $.ajax({
      url: '../../ajax/vl_searchLKomunitas.php',
      data: { search: search }, // Menggunakan objek untuk data
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
});

</script>
<?php include('../footer.php')?>
<!-- jQuery -->
</body>
</html>
