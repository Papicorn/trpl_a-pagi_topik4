<?php 
require '../koneksi.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    
    $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");
    
    if(mysqli_num_rows($cek_user) == 0) { ?>
        <p>Email tidak terdaftar!</p>
    <?php } else { 
    require '../send_mail.php';
    ?>
        <form method="POST">
            <p style="color:green;">Kode OTP telah dikirimkan melalui email, periksa email anda lalu masukkan kode OTP!</p>
            <input type="text" placeholder="Kode OTP" name="otp" id="otp" maxlength="6" required>
            <button type="submit" name="reset" id="reset">Reset</button>
        </form>
        
    <?php }
    } ?>