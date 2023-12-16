<?php 

$tanggal = date("Y-m-d");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$time = date("H:i:s");

$today = $tanggal . " " . $time;
?>