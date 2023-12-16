<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-grid.css">
    <link rel="stylesheet" href="bootstrap-grid.min.css">
    <link rel="stylesheet" href="bootstrap-reboot.css">
    <link rel="stylesheet" href="bootstrap-reboot.min.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <?php 
        session_start();
        require "../koneksi.php";
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
 
    <a class="navbar-brand" href="#"><img src="assets/image/logo.png" width="30" height="30"></a>
 
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
 
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">News <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Jelajahi Kegiatan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Komunitas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Donasi</a>
        </li>
        <li class="nav-item dropdown">
        </li>
      </ul>
 
      <button type="button" class="btn btn-success">Login</button>
      <a href="#" class="btn btn-outline-danger">Daftar</a>
   </div>
</nav>