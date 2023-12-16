<?php 
session_start();
require '../../koneksi.php';
require '../../config.php';

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    
      $cek_community = mysqli_query($koneksi, "SELECT * FROM community WHERE nama_komunitas LIKE '%$search%' AND status = 'disetujui' ORDER BY tgl_bergabung DESC");  
    
    
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
                      
                <?php }
}
?>
