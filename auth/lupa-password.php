<?php
session_start();
require '../koneksi.php';
require '../config.php';

// Cek apakah metode HTTP yang digunakan adalah POST
if (isset($_SESSION['email'])) {
    header('location:'.$weburl.'/dashboard/user');
} else {
    if (isset($_POST['reset'])) {
        $kodeOTP = $_POST['otp'];
        $ip = $ipaddress;
        
        $cek_otp = mysqli_query($koneksi, "SELECT * FROM kode_otp WHERE kode = '$kodeOTP' AND ip = '$ip' AND status = 'belum terpakai'");
        
        if(mysqli_num_rows($cek_otp) == 0) {
            echo '<script>alert("Kode OTP yang anda masukkan tidak sesuai");</script>';
        } else {
            header('location: reset-password.php?kode='.$kodeOTP);
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
        <div id="main">
            <input type="text" placeholder="Masukkan email" name="email" id="email" required>
            <button type="submit" name="button" style="background-color: green;" id="button">Kirim</button>
            <div id="p"></div>
        </div>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    
<script type="text/javascript">
    $(document).ready(function(){
      $("#button").click(function(){
        var email = $("#email").val();
		$.ajax({
			url: '/ajax/lupa_password.php',
			data: 'email=' + email,
			type: 'POST',
			dataType: 'html',
			success: function(data) {
				$("#main").html(data);
			}
		});
      });
    });
</script>
</body>
</html>