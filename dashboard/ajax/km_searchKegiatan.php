<?php 
session_start();
require '../../koneksi.php';
require '../../config.php';

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $id_community = $_SESSION['id_community'];
    $kategori = $_POST['kategori'];
    
    if($kategori == "judul") {
        $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE judul_kegiatan LIKE '%$search%' AND id_community = '$id_community' ORDER BY tgl_dibuat DESC");
    } elseif($kategori == "kategori") {
        $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE kategori LIKE '%$search%' AND id_community = '$id_community' ORDER BY tgl_dibuat DESC");
    } else {
      $cek_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE judul_kegiatan LIKE '%$search%' AND id_community = '$id_community' ORDER BY tgl_dibuat DESC");  
    }
    ?>
    <div class="card">
    <div class="card-body table-responsive p-0">
    <table class="table table-hover table-bordered text-nowrap">
                <thead class="bg-warning">
                  <tr>
                    <th>No</th>
                    <th>Judul Kegiatan</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 1;
                        
                        while ($row = mysqli_fetch_assoc($cek_kegiatan)) {
                            
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
                            
                    ?>
                  <tr>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id_kegiatan=<?= $row['id_kegiatan'] ?>&banner=<?= $row['banner'] ?>" method="POST">
                    <td><?= $no++ ?></td>
                    <td><?= $row['judul_kegiatan']; ?></td>
                    <td><?= $row['kategori']; ?></td>
                    <td><span class="badge badge-<?= $bg; ?>"><?= $status; ?></span></td>
                    <td><?= $tgl_dibuat; ?></td>
                    <td align="center"><a name="edit" class="btn btn-primary btn-sm text-light" data-toggle="modal" data-target="#ubahKegiatan<?= $row['id_kegiatan'] ?>"><i class="fas fa-edit"></i> Ubah</a>
                    <button type="submit" name="hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
                    <a name="show" href="<?= $weburl ?>/kegiatan/kegiatan.php?id_kegiatan=<?= $row['id_kegiatan'] ?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Lihat</button>
                    </td>
                    </form>
                  </tr>
                  
                    <!-- Modal Ubah kegiatan -->
                      <div class="modal fade" id="ubahKegiatan<?= $row['id_kegiatan'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-warning text text-light">
                              <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Ubah Kegiatan</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input style="hidden" value="<?= $row['id_kegiatan'] ?>" name="id_kegiatan" hidden> 
                                    <input style="hidden" value="<?= $row['banner'] ?>" name="banner" hidden> 
                                    <div class="form-group">
                                      <label>Judul Kegiatan</label>
                                      <input type="text" name="judul" class="form-control" placeholder="Masukkan judul" value="<?= $row['judul_kegiatan']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Kategori</label>
                                      <select class="form-control" name="kategori">
                                          <option value="<?= $row['kategori'] ?>" selected><?= $row['kategori'] ?></option>
                                          <option value="Sosialisasi">Sosialisasi</option>
                                          <option value="Gotong Royong">Gotong Royong</option>
                                      </select>
                                    </div>
                                  <div class="form-group">
                                      <label>Lokasi</label>
                                      <input type="text" name="lokasi" class="form-control" value="<?= $row['lokasi'] ?>" placeholder="Tambahkan Lokasi">
                                  </div>
                                  <div class="form-group">
                                      <label>Waktu Dimulai</label>
                                      <input type="datetime-local" name="waktu_mulai" class="form-control" value="<?= $mulai ?>">
                                  </div>
                                  <div class="form-group">
                                      <label>Waktu Selesai</label>
                                      <input type="datetime-local" name="waktu_selesai" class="form-control" value="<?= $selesai ?>">
                                  </div>
                                  <div class="form-group">
                                      <label>Tambahkan Banner</label>
                                      <input class="form-control" name="file" type="file" accept=".jpg, .png, .jpeg">
                                  </div>
                                    <div class="form-group">
                                      <label>Isi Kegiatan</label>
                                      <textarea class="form-control" name="isi" placeholder="Masukkan isi kegiatan" rows="5"><?= $row['isi_kegiatan'] ?></textarea>
                                  </div>
                                  <input type="submit" class="btn btn-success" name="ubah" value="Simpan">
                                </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                  <?php } ?>
                </tbody>
              </table>
              </div>
              </div>
<?php
}
?>
