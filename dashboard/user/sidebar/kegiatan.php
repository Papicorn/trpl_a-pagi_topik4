<?php 
session_start();
require '../../../koneksi.php';
require '../../../config.php';

if (!isset($_SESSION['email'])) {
    header('Location: ' . $weburl . '/auth/login.php');
    exit(); // Pastikan untuk keluar dari skrip setelah mengarahkan pengguna
}

$email = $_SESSION['email'];
$cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$email' OR email = '$email'");
$data_user = mysqli_fetch_assoc($cek_user);
        
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
            <?php if(isset($_SESSION['alert'])) : ?>
                <div class="alert alert-<?= $_SESSION['alert']['alert']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['alert']['judul']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['alert']); ?>
            <?php endif; ?>

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-5">
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
                <!-- card kegiatan -->
                <div class="content">
                    <div class="container-fluid mb-3">
                        <div class="row" id="list-kegiatan">
                            <?php 
                            $jumlahDataPerhalaman = 9;
                            $jumlahData = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kegiatan"));
                            $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
                            $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
                            $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

                            $cek_kegiatan1 = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY tgl_dibuat DESC LIMIT $awalData, $jumlahDataPerhalaman");
                            while ($row = mysqli_fetch_assoc($cek_kegiatan1)) {
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
                            ?>
                                <div class="col-md-6 col-lg-4 col-12 d-flex">
                                    <div class="card flex-fill" onclick="window.location.href='<?= $weburl ?>/kegiatan/kegiatan.php?id_kegiatan=<?= $row['id_kegiatan']; ?>'" style="border-radius: 10px; cursor: pointer;">
                                        <img src="../../../assets/img/kegiatan/<?= $row['banner'] ?>" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <div class="card-body">
                                            <label class="text-muted mb-0 font-weight-normal" style="font-style: 13px;">Kategori / <?= $row['kategori'] ?></label><span class="badge badge-<?php echo $bg ?> text-light" style="float: right;"><?php echo $status; ?></span><br>
                                            <h5 class="card-title" style="font-weight: bold;"><?= $row['judul_kegiatan'] ?></h5>
                                            <div class="card-text" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 1.5rem;" id="beritaD"><?= $row['isi_kegiatan'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div aria-label="Page navigation mb-3">
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
            var kategori = $('#kategori').val(); // Mengambil nilai dari input id_kategori

            $.ajax({
                url: '../../ajax/vl_searchKegiatan.php',
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
