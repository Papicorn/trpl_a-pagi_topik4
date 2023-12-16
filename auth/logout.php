<?php  
session_start();
require '../koneksi.php';

if(isset($_SESSION['id_community'])) {
    session_destroy();
    header('location:'.$weburl.'/auth/loginkom.php');    
} elseif  (isset($_SESSION['email'])) {
    session_destroy();
    header('location:'.$weburl.'/auth/login.php');
}

?>