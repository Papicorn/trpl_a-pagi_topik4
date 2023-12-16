<?php 

$servername = "localhost";
$username = "molg1696_kitapeduli";
$pw = "zacgq15.";
$database = "molg1696_kitapeduli";
$weburl = "https://kitapeduli.molba.xyz";

$koneksi = mysqli_connect($servername, $username, $pw, $database);

if (mysqli_connect_errno()){
    echo "koneksi databse gagal:". mysqli_connect_error();
}

?>