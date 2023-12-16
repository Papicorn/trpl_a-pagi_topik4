<?php 
session_start();
require '../../koneksi.php';
require '../../config.php';

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $kategori = $_POST['kategori'];
    
    if($kategori == "judul") {
        $cek_berita = mysqli_query($koneksi, "SELECT * FROM news WHERE judul LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    } elseif($kategori == "kategori") {
        $cek_berita = mysqli_query($koneksi, "SELECT * FROM news WHERE kategori LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    } else if ($kategori == "hastag") {
      $cek_berita = mysqli_query($koneksi, "SELECT * FROM news WHERE hastag LIKE '%$search%' ORDER BY tgl_dibuat DESC");  
    } else {
        $cek_berita = mysqli_query($koneksi, "SELECT * FROM news WHERE judul LIKE '%$search%' ORDER BY tgl_dibuat DESC");
    }
    
                while ($row = mysqli_fetch_assoc($cek_berita)) {
                    
                    $tgl_dibuat = date('d M Y', strtotime($row['tgl_dibuat']));
                    
              ?>
              
            <tr>
                      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?id_news=<?= $row['id_news'] ?>&banner=<?= $row['banner'] ?>">
                        <td><?= $awalData =+ 1 ?></td>
                        <td><?= $row['judul']; ?></td>
                        <td><?= $row['kategori']; ?></td>
                        <td><?php
                                $hastag = $row['hastag'];
                                echo preg_replace('/[ ,]+/', ' ', trim($hastag));
                            ?></td>
                        <td><?= $tgl_dibuat; ?></td>
                        <td align="center"><a name="edit" class="btn btn-primary btn-sm text-light" data-toggle="modal" data-target="#ubahNews<?= $row['id_news'] ?>"><i class="fas fa-edit"></i> Ubah</a>
                        <button type="submit" name="hapus" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
                        <a name="show" href="<?= $weburl ?>/berita/berita.php?id_news=<?= $row['id_news'] ?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Lihat</a>
                        </td>
                    </form>
                  </tr>
                  
                    <!-- Modal Ubah kegiatan -->
                      <div class="modal fade" id="ubahNews<?= $row['id_news'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-warning text text-light">
                              <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Ubah News</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input style="hidden" value="<?= $row['id_news'] ?>" name="id_news" hidden> 
                                    <input style="hidden" value="<?= $row['banner'] ?>" name="banner" hidden> 
                                    <div class="form-group">
                                      <label>Judul News</label>
                                      <input type="text" name="judul" class="form-control" placeholder="Masukkan judul" value="<?= $row['judul']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Kategori</label>
                                      <select class="form-control" name="kategori">
                                          <option value="<?= $row['kategori'] ?>" selected><?= $row['kategori'] ?></option>
                                          <option value="Peristiwa">Peristiwa</option>
                                          <option value="Edukasi">Edukasi</option>
                                          <option value="Kreatif">Kreatif</option>
                                          <option value="Kesehatan">Kesehatan</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label>Hastag <small>(Example: #hebat,#kegiatan,#indonesiahebat)</small></label>
                                      <input type="text" name="hastag" class="form-control" placeholder="Masukkan hastag" value="<?= $row['hastag']; ?>">
                                    </div>
                                     <div class="form-group">
                                      <label>Tambahkan Banner <small>(16:9)</small></label>
                                      <input class="form-control" name="file" type="file" accept=".jpg, .png, .jpeg">
                                    </div>
                                    <div class="form-group">
                                      <label>Isi Berita</label>
                                      <textarea class="form-control" name="isi" placeholder="Masukkan isi berita" rows="5"><?= $row['isi_news'] ?></textarea>
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
            <?php }
}
?>
