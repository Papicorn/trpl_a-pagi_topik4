<?php
session_start();
require '../koneksi.php';
require '../config.php';

// Cek apakah metode HTTP yang digunakan adalah POST
if (isset($_SESSION['email'])) {
    header('location:'.$weburl.'/dashboard/user');
} else {
    if (!isset($_GET['kode'])) {
        header('location: lupa-password.php');
    } else {
        $kodeOTP = $_GET['kode'];
        $ip = $ipaddress;
        $cek_otp = mysqli_query($koneksi, "SELECT * FROM kode_otp WHERE kode = '$kodeOTP' AND ip = '$ip' AND status = 'belum terpakai' AND date = '$tanggal'");
        $data_otp = mysqli_fetch_assoc($cek_otp);
        $emailOTP = $data_otp['email'];
        
        $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$emailOTP'");
        
        if (mysqli_num_rows($cek_otp) == 0) {
            header('location: lupa-password.php');
        } else {
            if (isset($_POST['reset'])) {
                $password = mysqli_real_escape_string( $koneksi, $_POST['password']);
                $password = password_hash($password, PASSWORD_DEFAULT);
                $password2 = password_hash($password2, PASSWORD_DEFAULT);
                
                if ($password != $password2) {
                    echo '<script>alert("Gagal mengganti password baru");</script>';
                }
                
                if(mysqli_query($koneksi, "UPDATE user SET password = '$password' WHERE email = '$emailOTP'")) {
                    mysqli_query($koneksi, "UPDATE kode_otp SET status = 'terpakai' WHERE kode = '$kodeOTP'");
                    header('location: login.php');
                } else {
                    echo '<script>alert("Gagal mengganti password baru");</script>';
                }
            } 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="../assets/img/logo.png" rel="icon">
</head>
<body>

    <div class="login-container">
    <a href="<?php echo $weburl; ?>"><img src="../assets/image/kitapeduli.png" class="img-logo"></a>
    <h2>Lupa password</h2>
    <form method="POST">
        <div id="main">
            <label id="icon" onclick="lihat()" style="float: right; margin-right:17px; margin-bottom:2px; font-size: 14px;">Lihat Password <i class="fa-solid fa-eye"></i></label>
            <input type="password" placeholder="Masukkan password baru" name="password" id="password" minlength="8" required>
            <input type="password" placeholder="Konfirmasi password" name="password2" id="password2" minlength="8" required>
            <button type="submit" name="reset" id="reset">Kirim</button>
        </div>
    </form>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    
    <script type="text/javascript">
        function lihat() {
            var password = document.getElementById('password');
            var button = document.getElementById('icon');

            if (password.type === "password") {
                password.type = "text";
                password2.type = "text";
                button.innerHTML = 'Sembunyikan <i class="fa-solid fa-eye-slash"></i>';
            } else {
                password.type = "password";
                password2.type = "password";
                button.innerHTML = 'Lihat Password <i class="fa-solid fa-eye"></i>';
            }
        }
    </script>
</body>
</html>