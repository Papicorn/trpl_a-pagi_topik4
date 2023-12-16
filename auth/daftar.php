<?php 
session_start();
require '../koneksi.php';
require '../config.php';

if (isset($_POST['submit'])){
    $username = mysqli_real_escape_string( $koneksi, $_POST['username']);
    $password = mysqli_real_escape_string( $koneksi, $_POST['password']);
    $email = mysqli_real_escape_string( $koneksi, $_POST['email']);
    $namalengkap = mysqli_real_escape_string( $koneksi, $_POST['namalengkap']);
    $alamat = mysqli_real_escape_string( $koneksi, $_POST['alamat']);
    $nik = mysqli_real_escape_string( $koneksi, $_POST['nik']);
    $nohp = mysqli_real_escape_string( $koneksi, $_POST['nohp']);
    $ttl = mysqli_real_escape_string( $koneksi, $_POST['ttl']);
    $jeniskelamin = mysqli_real_escape_string( $koneksi, $_POST['jeniskelamin']);

    $password = password_hash($password, PASSWORD_DEFAULT);

    $cek_user = mysqli_query($koneksi,"SELECT * FROM user WHERE username = '$username' OR nama_lengkap = '$namalengkap' LIMIT 1");
    $data_user = mysqli_fetch_assoc($cek_user);
   
    if (mysqli_num_rows($cek_user) == 0) {
        if (mysqli_query($koneksi, "INSERT INTO `user` VALUES ('','$username','$password','$alamat','$nik', '$namalengkap', '$jeniskelamin', NULL,'','$ttl','$nohp','$email','Aktif', 'user', '$tanggal')") == TRUE) {
            header('location: '. $weburl .'/auth/login.php');
        } else {
            echo '<script>alert("Pendaftaran gagal, silahkan laporkan kepada CS atau daftar ulang!");</script>';
        }
    } else {
        echo '<script>alert("Pengguna sudah terdaftar!");</script>';
    }
}   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="../assets/css/daftarweb.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="../assets/img/logo.png" rel="icon">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <div class="daftar-container">
            <a href="<?php echo $weburl; ?>"><img src="../assets/image/kitapeduli.png" style="width: 300px;"></a>
            <h2>DAFTAR</h2>
            <form method="post">
                <table>
                    <tr>
                        <td class="label1"><label for="nama-lengkap" class="nama-lengkap">Nama Lengkap:</label></td>
                        <td class="label11"><label for="username" class="username">Username:</label></td>
                    </tr>
                    <tr>
                        <td class="input1"><input type="text" id="nama-lengkap" name="namalengkap" class="inputan" required></td>
                        <td class="input11"><input type="text" id="username" name="username" class="inputan" minlength="3" required></td>
                    </tr>
                    <tr>
                        <td class="label2"><label for="email">Email:</label></td>
                        <td class="label22"><label for="password">Password:  <label id="passwordToggleIcon" onclick="togglePassword()" style="float: right; margin-right: 5px;"><i class="fa-solid fa-eye"></i></label></label></td>
                    </tr>
                    <tr>
                        <td class="input2"><input type="email" id="email" name="email" class="inputan" required></td>
                        <td class="input22"><input type="password" id="password" name="password" class="inputan" minlength="8" maxlength="16" required><td>
                    </tr>
                    <tr>
                        <td class="label3"><label for="alamat">NIK:</label></td>
                        <td class="label33"><label for="nohp">No Hp:</label></td>
                    </tr>
                    <tr>
                        <td class="input3"><input type="number" name="nik" class="input-nik" maxlength="16" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required></td>
                        <td class="input33" style="vertical-align: top;"><input type="number" id="nohp" name="nohp" class="inputan" required></td>
                    </tr>
                    <tr>
                        <td class="label4"><label for="ttg">Tanggal Lahir:</label></td>
                        <td class="label44"><label for="jeniskelamin">Jenis Kelamin:</label></td>
                    </tr>
                    <tr>
                        <td class="input4"><input type="date" name="ttl" class="ttl" required></td>
                        <td class="input44"><input type="radio" name="jeniskelamin" id="jeniskelamin" value="pria" required>Pria
                            <input type="radio" name="jeniskelamin" id="jeniskelamin" value="wanita">Wanita</td>
                    </tr>
                    <tr>
                        <td class="label5"><label for="alamat">Alamat:</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="input55"><textarea name="alamat" id="alamat" class="textarea" width="20" required></textarea></td>
                    </tr>
                </table>
                <input type="submit" class="button-daftar" name="submit" value="Daftar">
                <p>Sudah memiliki akun? <a href="login.php">Login</a></p>
            </form>
        </div>
    <script type="text/javascript">
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var icon = document.getElementById("passwordToggleIcon");
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.innerHTML = '<i class="fa-solid fa-eye-slash"></i>'; // Ubah ikon ke "visibility_off" (sandi terlihat)
            } else {
                passwordField.type = "password";
                icon.innerHTML = '<i class="fa-solid fa-eye"></i>'; // Ubah ikon ke "visibility" (sandi tersembunyi)
            }
        }
    </script>
</body>
</html>