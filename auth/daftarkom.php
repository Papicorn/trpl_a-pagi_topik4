<?php
session_start();
require '../koneksi.php';
require '../config.php';

$targetDirectory = "../uploads/sertifikat/";
$targetDirectory1 = "../assets/img/komunitas-profile/";

if(isset($_POST["submit"])) {
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $pdfFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    $targetFile1 = $targetDirectory1 . basename($_FILES["gambar"]["name"]);
    $uploadOk1 = 1;
    $imageFileType1 = strtolower(pathinfo($targetFile1, PATHINFO_EXTENSION));
    
    $profile = basename($_FILES["gambar"]["name"]);
    
    $check = getimagesize($_FILES["file"]["tmp_name"]);

    $nama_perwakilan = mysqli_real_escape_string( $koneksi, $_POST['nama_perwakilan']);
    $nama_komunitas = $_POST['nama_komunitas'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $password = password_hash($pass, PASSWORD_DEFAULT); 
    $deskripsi = $_POST['deskripsi'];
    $nohp = $_POST['nohp'];
    $date = $_POST['date'];
    $sertifikat = basename($_FILES["file"]["name"]);
    
    $cek_user = mysqli_query($koneksi, "SELECT * FROM user WHERE nama_lengkap = '$nama_perwakilan'");
    $data_user = mysqli_fetch_assoc($cek_user);
    $id_user = $data_user['id_user'];

    if($pdfFileType != "pdf") {
        echo '<script>alert("maaf, hanya menerima format pdf!");</script>';
        $uploadOk = 0;
    }

    if (file_exists($targetFile)) {
        echo '<script>alert("maaf, nama file yang sama sudah ada. Harap mengganti nama file!");</script>';
        $uploadOk = 0;
    }

    if ($_FILES["file"]["size"] > 5000000) {
        echo '<script>alert("maaf, file yang dikirimkan maksimal 50 MB!");</script>';
        $uploadOk = 0;
    }
    
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType1, $allowedFormats)) {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo '<script>alert("maaf, file tidak terkirim!");</script>';
    } else {
        $cek_komunitas = mysqli_query($koneksi, "SELECT * FROM community WHERE nama_komunitas = '$nama_komunitas' OR email = '$email'");
        if (mysqli_num_rows($cek_komunitas) == 0) {
            if (mysqli_query($koneksi, "INSERT INTO `community` VALUES ('', '$nama_komunitas','$deskripsi','$password','$id_user','$nohp','$email', '$profile', '$sertifikat', 'belum disetujui', '$date')") == TRUE) {
                $data_ck = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_community FROM community ORDER BY tgl_bergabung DESC"));
                $IDcom = $data_ck['id_community'];
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile) == TRUE && mysqli_query($koneksi, "UPDATE user SET id_community = '$IDcom' WHERE id_user = '$id_user'") && move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile1) == TRUE && mysqli_query($koneksi, "INSERT INTO gabung_community VALUES ('', '$id_user', '$IDcom', 'disetujui', '$date')") == TRUE) {
                    echo '<script>alert("Komunitas terdaftar, tunggu admin menyetujui!");</script>';
                    header('location: '. $weburl .'/auth/loginkom.php');
                } else {
                    echo '<script>alert("maaf, ada kesalahan saat menambahkan file anda!");</script>';
                }
            } else {   
                echo '<script>alert("Maaf, ada kesalahan saat memasukkan data ke server! '.$id_user.'");</script>';
            }  
        } else {
            echo '<script>alert("Nama Komunitas atau email sudah terdaftar!");</script>';
        }
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
            <h2>DAFTAR</h2>
            <form method="POST" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td class="label1"><label for="nama_perwakilan" class="nama_perwakilan">Nama Perwakilan:</label></td>
                        <td class="label11"><label for="username" class="username">Nama Komunitas:</label></td>
                    </tr>
                    <tr>
                        <td class="input1"><input required type="text" id="nama_perwakilan" name="nama_perwakilan" class="inputan"></td>
                        <td class="input11"><input required type="text" id="nama_komunitas" name="nama_komunitas" class="inputan"></td>
                    </tr>
                    <tr>
                        <td class="label2"><label for="email">Email:</label></td>
                        <td class="label22"><label for="password">Password: <label id="passwordToggleIcon" onclick="togglePassword()" style="float: right; margin-right: 5px;"><i class="fa-solid fa-eye"></i></label></label></td>
                    </tr>
                    <tr>
                        <td class="input2"><input required type="email" id="email" name="email" class="inputan"></td>
                        <td class="input22"><input required type="password" id="password" name="password" class="inputan"><d>
                    </tr>
                    <tr>
                        <td class="label3"><label for="Deskripsi Komunitas">Deskripsi komunitas:</label></td>
                        <td class="label33"><label for="nohp">No Hp:</label></td>
                    </tr>
                    <tr>
                        <td class="input3"><textarea name="deskripsi" id="deskripsi" class="textarea"></textarea></td>
                        <td class="input33" style="vertical-align: top;"><input required type="number" id="nohp" name="nohp" class="inputan"></td>
                    </tr>
                    <tr>
                        <td class="label4"><label for="ttg">Tanggal Berdiri Komunitas:</label></td>
                        <td class="label44"><label for="Tanggal Berdiri komunitas"></label></td>
                    </tr>
                    <tr>
                        <td class="input4"><input required type="date" class="date" name="date"></td>
                    </tr>
                    <tr>
                        <td class="Sertifikat">Sertifikat Komunitas:<br><input required type="file" id="file" name="file" accept=".pdf"></td>
                        <td class="Sertifikat">Profile komunitas:<br><input required type="file" id="gambar" name="gambar" accept=".jpg, .png, .jpeg"></td>
                    </tr>
                </table>
                <button class="button-daftar" name="submit">Daftar</button>
            
                <p>Sudah memiliki akun? <a href="loginkom.php">Login</a></p>
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