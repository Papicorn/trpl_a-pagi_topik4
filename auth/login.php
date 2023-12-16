<?php
session_start();
require '../koneksi.php';
require '../config.php';

// Cek apakah metode HTTP yang digunakan adalah POST
if (isset($_SESSION['email'])) {
    header('location:'.$weburl.'/dashboard/user');
} else  {
    if (isset($_POST['login'])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Query untuk mencari pengguna dengan username dan password yang sesuai
        $sql = "SELECT * FROM user WHERE email='$email' OR username ='$email'";
        $result = $koneksi->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row["password"]; // Kolom password di tabel database

            // Memeriksa apakah password sesuai
            if ( password_verify($password, $stored_password) ) {
                if (mysqli_query($koneksi, "INSERT INTO riwayat_login VALUES ('', '$row[id_user]', '$ipaddress', '$time', '$tanggal')") == TRUE) {
                    $_SESSION['email'] = $email;
                    header('location:'.$weburl.'/dashboard/user');
                } else {
                    echo "<script>alert('Login gagal. coba lagi nanti.');</script>";
                }
            } else {
                echo "<script>alert('Login gagal. Periksa kembali username dan password Anda.');</script>";
            }
        } else {
            echo "<script>alert('Login gagal. Periksa kembali username dan password Anda.');</script>";
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
    <link href="../assets/img/logo.png" rel="icon">
    
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

</head>
<body>

<form method="post" class="formnya">
                <?php  
                    if(isset($_SESSION['alert'])) {
                ?>
                <div class="alert alert-<?php echo $_SESSION['alert']['alert']; ?> alert-dismissible fade show" role="alert">
                  <?php echo $_SESSION['alert']['judul']; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    unset($_SESSION['alert']); 
                    } 
                ?>
                
                <script>
                    var alertList = document.querySelectorAll('.alert')
                    alertList.forEach(function (alert) {
                      new bootstrap.Alert(alert)
                    })
                </script>
    <div class="col-12 login-container">
    <a href="<?php echo $weburl; ?>"><img src="../assets/image/kitapeduli.png" class="img-logo"></a>
    <h2>Login</h2>
        <input type="text" placeholder="Email/Username" name="email" required>
        <label id="icon" onclick="lihat()" style="float: right; margin-right:17px; margin-bottom:2px; font-size: 14px;">Lihat Password <i class="fa-solid fa-eye"></i></label>
        <input type="password" placeholder="Password" name="password" id="password" required>
        <a href="lupa-password.php" class="forget"><span>Lupa Password?</span></a><br><br>
        <button type="submit" name="login">Login</button>
        <p style="margin-bottom: 0;">Belum punya akun? <a href="<?php echo $weburl; ?>/auth/daftar.php">Daftar Disini</a></p>
        <p style="margin-bottom: 0; margin-top: 5px;">Login sebagai komunitas? <a href="loginkom.php">Klik disini</a></p>
</form> 
    <script type="text/javascript">
        function lihat() {
            var password = document.getElementById('password');
            var button = document.getElementById('icon');

            if (password.type === "password") {
                password.type = "text";
                button.innerHTML = 'Sembunyikan <i class="fa-solid fa-eye-slash"></i>';
            } else {
                password.type = "password";
                button.innerHTML = 'Lihat Password <i class="fa-solid fa-eye"></i>';
            }
        }
    </script>
    
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>