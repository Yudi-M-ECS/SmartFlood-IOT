<?php
  $server = "localhost";
  $user = "root";
  $pasword = "";
  $dbname = "smartfloodWeb_db";

  $koneksi = mysqli_connect($server, $user, $pasword, $dbname);

  if(!$koneksi){
    echo "Terhubung" . mysqli_connect_error();
  }
?>