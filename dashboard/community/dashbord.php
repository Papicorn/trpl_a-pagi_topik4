<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- fullcalendar css  -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css' rel='stylesheet' />
</head>
<body>
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row d-flex justify-content-center">
        <div class="col-md-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $jumlah_kegiatan ?></h3>

                <p>Kegiatan</p>
              </div>
              <div class="icon">
              <i class="ion ion-calendar"></i>
              </div>
              <a href="sidebar/kegiatan.php" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $jumlah_ulasan; ?></h3>

                <p>Ulasan</p>
              </div>
              <div class="icon">
              <i class="nav-icon fas fa-bookmark"></i>
              </div>
              <a href="sidebar/kegiatan.php" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $jumlah_anggota ?></h3>

                <p>Anggota</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="sidebar/anggota.php" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
      </div>
      <!-- /.row -->

      <!-- Kalender -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
              <h3>Kalender Kegiatan</h3>
              <div class="col-lg-12 d-flex justify-content-center">
                  <div id="calendar" class="col-lg-8 col-sm-12"></div>
              </div>
          </div>
        </div>
      </section>
      <!-- /.content -->

      <!-- Your existing scripts, including the jQuery and calendar initialization -->
      <section class="content">
        <div class="container-fluid">
          <div class="row mb-4">
            <div class="col-md-3">
              <div class="sticky-top mb-3">
                <div class="card">
                  <!-- the events -->
                  <div id="external-events"></div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-12">
                <div class="d-flex justify-content-between">
                  <h3>Kegiatan</h3>
                    <a class="btn btn-outline-success" href="sidebar/kegiatan.php">
                      <i class="fas fa-plus"></i>  Tambah Kegiatan
                    </a>
                </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- card kegiatan -->
      <div class="content">
        <div class="container-fluid mb-3">
          <div class="row overflow-auto flex-nowrap" id="scrollContainer">
              <?php 
                $cek_kegiatan1 = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_community = '$id_community' ORDER BY tgl_dibuat DESC LIMIT 10");
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
              
            <div class="col-md-4 col-10 d-flex">
              <div class="card flex-fill" style="border-radius: 10px;">
                <img src="../../assets/img/kegiatan/<?= $row['banner'] ?>" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <div class="card-body">
                  <label class="text-muted mb-0" style="font-style: 13px;">Kategori / <?= $row['kategori'] ?></label><span class="badge badge-<?php echo $bg ?> text-light" style="float: right;"><?php echo $status; ?></span>
                  <h5 class="card-title" style="font-weight: bold;"><?= $row['judul_kegiatan'] ?></h5>
                  <div class="card-text" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-height: 1.7rem;" id="beritaD"><?= $row['isi_kegiatan'] ?></div>
                </div>
                <div class="card-footer">
                      <div class="float-right">
                          <a href="sidebar/kegiatan.php" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Ubah</a>
                          <a href="<?= $weburl ?>/kegiatan/kegiatan.php?id_kegiatan=<?= $row['id_kegiatan']; ?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Lihat</a>
                      </div>
                  </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      
      <!-- Tabel anggota -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Anggota Komunitas</h3>
              <div class="card-tools pe-5">
                <a class="text-primary" href="sidebar/anggota.php" style="cursor: pointer;">
                    Lihat lainnya
                </a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Nama Lengkap</th>
                    <th>Status</th>
                    <th>Tanggal Bergabung</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                        $cek_gabungCommunity1 = mysqli_query($koneksi, "SELECT * FROM gabung_community WHERE id_community = '$id_community' ORDER BY tgl_gabung ASC LIMIT 10");
                        while ($row_bergabung = mysqli_fetch_assoc($cek_gabungCommunity1)) {
                            $id_userGabung = $row_bergabung['id_user'];
                            
                            $cek_userGabung = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_userGabung'");
                            $data_userGabung = mysqli_fetch_assoc($cek_userGabung);
                            
                            if($row_bergabung['status'] == "disetujui") {
                                $bg = "success";
                            } else {
                                $bg = "danger";
                            }
                            
                    ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data_userGabung['username']; ?></td>
                    <td><?= $data_userGabung['nama_lengkap']; ?></td>
                    <td><span class="badge badge-<?= $bg ?>"><?= $row_bergabung['status']; ?></span></td>
                    <td><?= $row_bergabung['tgl_gabung']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div>
  </section>
  </section>
  
            <script>
                // Mendapatkan elemen div
                var myDiv = document.getElementById('beritaD');
                
                // Mengambil teks dari elemen div (tanpa elemen HTML)
                var textOnly = myDiv.textContent || myDiv.innerText;
                
                // Menampilkan teks yang hanya berisi teks (tanpa elemen HTML)
                console.log(textOnly); // atau Anda bisa menampilkan di mana saja sesuai kebutuhan

            </script>
</body>
</html>
