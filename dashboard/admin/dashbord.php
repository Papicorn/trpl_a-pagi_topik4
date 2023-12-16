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
        <div class="row d-flex justify-content-center">
          <div class="col-md-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?= $jumlah_user1 ?></h3>

                <p>Sukarelawan</p>
              </div>
              <div class="icon">
              <i class="ion ion-person-add"></i>
              </div>
              <a href="sidebar/volunteer.php" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
        <div class="col-md-3 col-6">
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
          <div class="col-md-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $jumlah_community; ?></h3> 

                <p>Komunitas</p>
              </div>
              <div class="icon">
              <i class="fas fa-users"></i>
              </div>
              <a href="sidebar/komunitas.php" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> 
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $jumlah_berita ?></h3>

                <p>Berita</p>
              </div>
              <div class="icon">
                <i class="nav-icon far fa-newspaper"></i>
              </div>
              <a href="sidebar/berita.php" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
      </div>
      
      <!-- Kalender -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
              <div class="col-12 d-flex justify-content-center">
                  <div id="calendar" class="col-sm-12 col-md-8"></div>
              </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
      
      
      <section class="content mt-3">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-sm-12">
                <div class="d-flex justify-content-between">
                  <h3>Kegiatan</h3>
                    <a class="text-link d-flex align-items-center" href="sidebar/kegiatan.php">
                      Lihat Selengkapnya
                    </a>
                </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- card kegiatan -->
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
                    <th>Judul Kegiatan</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tergabung</th>
                    <th>Tanggal Dibuat</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 1;
                        $cek_kegiatan1 = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY tgl_dibuat DESC LIMIT 5");
                        while ($row = mysqli_fetch_assoc($cek_kegiatan1)) {
                            
                            $today = $tanggal . " " . $time;
                            
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
                            
                            $tgl_dibuat = date('d M Y', strtotime($row['tgl_dibuat']));
                            
                            $idKegiatan = $row['id_kegiatan'];
                            $cek_gabungK = mysqli_query($koneksi, "SELECT * FROM gabung_kegiatan WHERE id_kegiatan = '$idKegiatan'");
                            $jumlahGabungK = mysqli_num_rows($cek_gabungK);
                            
                    ?>
                  <tr>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id_kegiatan=<?= $row['id_kegiatan'] ?>&banner=<?= $row['banner'] ?>" method="POST">
                    <td><?= $no++ ?></td>
                    <td><?= $row['judul_kegiatan']; ?></td>
                    <td><?= $row['kategori']; ?></td>
                    <td><span class="badge badge-<?= $bg; ?>"><?= $status; ?></span></td>
                    <td><?= $jumlahGabungK; ?> <a href="sidebar/pengguna-tergabung.php?id_kegiatan=<?= $row['id_kegiatan']; ?>" class="text-muted font-weight-normal pe-auto" style="font-size: 14px;">(Lihat)</a></td>
                    <td><?= $tgl_dibuat; ?></td>
                    </form>
                  </tr>
                      
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
        </section>
      
      <section class="content mt-3">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-sm-12">
                <div class="d-flex justify-content-between">
                  <h3>Berita</h3>
                    <a class="text-link d-flex align-items-center" href="sidebar/berita.php">
                      Lihat Selengkapnya
                    </a>
                </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- card kegiatan -->
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
                    <th>Judul Berita</th>
                    <th>Kategori</th>
                    <th>Hastag</th>
                    <th>Tanggal Dibuat</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $no1 = 1;
                        $cek_berita1 = mysqli_query($koneksi, "SELECT * FROM news ORDER BY tgl_dibuat DESC LIMIT 5");
                        while ($row1 = mysqli_fetch_assoc($cek_berita1)) {
                            
                            $tgl_dibuat = date('d M Y', strtotime($row1['tgl_dibuat']));
                            
                    ?>
                  <tr>
                    <td><?= $no1++ ?></td>
                    <td><?= $row1['judul']; ?></td>
                    <td><?= $row1['kategori']; ?></td>
                    <td><?php
                            $hastag = $row1['hastag'];
                            echo preg_replace('/[ ,]+/', ' ', trim($hastag));
                        ?></td>
                    <td><?= $tgl_dibuat; ?></td>
                  </tr>
                      
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
        </section>
      
      <section class="content mt-3">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-sm-12">
                <div class="d-flex justify-content-between">
                  <h3>Sukarelawan</h3>
                    <a class="text-link d-flex align-items-center" href="sidebar/volunteer.php">
                      Lihat Selengkapnya
                    </a>
                </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- card kegiatan -->
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
                    <th>Komunitas</th>
                    <th>Status</th>
                    <th>Tgl bergabung</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $no2 = 1;
                        $cek_user1 = mysqli_query($koneksi, "SELECT * FROM user WHERE level = 'user' ORDER BY tgl_bergabung DESC LIMIT 5");
                        while ($row2 = mysqli_fetch_assoc($cek_user1)) {
                        
                        $idCom = $row2['id_community'];
                        
                        $cekCom1 = mysqli_query($koneksi, "SELECT * FROM community WHERE id_community = '$idCom'");
                        $dataCom1 = mysqli_fetch_assoc($cekCom1);
                        
                        if(mysqli_num_rows($cekCom1) == 0) {
                            $komunitas = "-";
                        } else {
                            $komunitas = $dataCom1['nama_komunitas'];
                        }
                            
                    ?>
                  <tr>
                    <td><?= $no2++ ?></td>
                    <td><?= $row2['username']; ?></td>
                    <td><?= $row2['nama_lengkap']; ?></td>
                    <td><?= $row2['kelamin']; ?></td>
                    <td><?= $komunitas ?></td>
                    <td><?= $row2['status'] ?></td>
                    <td><?= $row2['tgl_bergabung']; ?></td>
                  </tr>
                      
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
        </section>
      <!-- Tabel anggota -->
      
      <!-- /.row -->
    </div>
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
