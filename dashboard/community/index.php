<?php 
    session_start();
    require '../../koneksi.php';
    require '../../config.php';
    
    if(!isset($_SESSION['id_community'])){
        header('Location: ' . $weburl . '/auth/loginkom.php');
    } else {
    
        $id_community = $_SESSION['id_community'];
        
        /* ==== CEK ==== */
        $cek_settings = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
        $cek_community = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$id_community'");
        $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_community = '$id_community'");
        $cek_gabungCommunity = mysqli_query($koneksi, "SELECT * FROM gabung_community WHERE id_community = '$id_community' AND status = 'disetujui'");
        
        /* ==== INNER ====*/
        $inner_jumlah_ulasan = mysqli_query($koneksi, "SELECT COUNT(ulasan.id_ulasan) AS total_ulasan FROM community LEFT JOIN kegiatan ON community.id_community = kegiatan.id_community LEFT JOIN ulasan ON kegiatan.id_kegiatan = ulasan.id_kegiatan WHERE community.id_community = '$id_community'");
        
        /* ==== DATA ==== */
        $data_settings = mysqli_fetch_assoc($cek_settings);
        $data_community = mysqli_fetch_assoc($cek_community);
        $data_inner_jumlah_ulasan = mysqli_fetch_assoc($inner_jumlah_ulasan);
        
        /* ==== JUMLAH ==== */
        $jumlah_kegiatan = mysqli_num_rows($cek_kegiatan);
        $jumlah_ulasan = $data_inner_jumlah_ulasan['total_ulasan'];
        $jumlah_anggota = mysqli_num_rows($cek_gabungCommunity);
        
        
    }
    
?>
<!DOCTYPE html>
<html>
<?php include ('header.php')?> 
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include ('navbar.php'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
      <?php require 'sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"> <a href="#"></a></li>
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php include('dashbord.php')?>
    <!-- /.content -->
  </div>
  
  <!-- /.content-wrapper -->
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include('footer.php')?>
<!-- jQuery -->

        <!-- ====== Calendar ====== --><script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: [ 
                        <?php 
                            while ($dk = mysqli_fetch_array($cek_kegiatan)) {
                                if ($dk['kategori'] == "Gotong Royong") {
                                    $color = 'green';
                                } elseif ($dk['kategori'] = "Sosialisasi") {
                                    $color = 'orange';
                                } else {
                                    $color = "blue";
                                }
                        ?>
                        {
                            title: '<?php echo $dk['judul_kegiatan']; ?>',
                            start: '<?php echo $dk['tgl_mulai'] . " " . $dk['waktu_mulai']; ?>',
                            end: '<?php echo $dk['tgl_selesai'] . " " . $dk['waktu_selesai']; ?>',
                            url: 'https://kitapeduli.molba.xyz/kegiatan/kegiatan.php?id_kegiatan=<?php echo $dk['id_kegiatan']; ?>',
                            color: '<?php echo $color ?>'
                        },
                        <?php } ?>
                        
                    ],
                    selectOverlap: function (event) {
                        return event.rendering === 'background';
                    }
                    
                });
    
                calendar.render();
            });
        </script>

</body>
</html>
