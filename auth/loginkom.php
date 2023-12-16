<?php
session_start();
require '../koneksi.php';

// Cek apakah metode HTTP yang digunakan adalah POST
if (isset($_SESSION['id_community'])) {
    header('location:'.$weburl.'/dashboard/community');
} else  {
    if (isset($_POST['login'])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        $cek_community = mysqli_query($koneksi, "SELECT * FROM community WHERE email = '$email'");
        $data_community = mysqli_fetch_assoc($cek_community);
        
        if($data_community['status'] == "belum disetujui") {
            echo "<script>alert('Login gagal. Komunitas belum disetujui.');</script>";
        } else {

            // Query untuk mencari pengguna dengan username dan password yang sesuai
            $sql = "SELECT * FROM community WHERE email='$email'";
            $result = $koneksi->query($sql);
    
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $stored_password = $row["password"]; // Kolom password di tabel database
    
                // Memeriksa apakah password sesuai
                if ( password_verify($password, $stored_password) ) {
                    $_SESSION['id_community'] = $data_community['id_community'];
                    header('location:'.$weburl.'/dashboard/community');
                } else {
                    echo "<script>alert('Login gagal. Periksa kembali email dan password Anda.');</script>";
                }
            } else {
                echo "<script>alert('Login gagal. Periksa kembali email dan password Anda.');</script>";
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
    <link href="../assets/img/logo.png" rel="icon">
</head>
<body>

<form method="post">
    <div class="login-container">
    <a href="<?php echo $weburl; ?>"><img src="../assets/image/kitapeduli.png" class="img-logo"></a>
    <h2>Login</h2>
    <form>
        <input type="email" placeholder="Email" name="email" required>
        <label id="icon" onclick="lihat()" style="float: right; margin-right:17px; margin-bottom:2px; font-size: 14px;">Lihat Password <i class="fa-solid fa-eye"></i></label>
        <input type="password" placeholder="Password" name="password" id="password" required>
        <a href="lupa-password.php" class="forget"><span>Lupa Password?</span></a><br><br>
        <button type="submit" name="login">Login</button>
        <p style="margin-bottom: 0">Belum punya akun? <a href="<?php echo $weburl; ?>/auth/daftarkom.php">Daftar Disini</a></p>
    </form> 
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
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
</body>
</html>