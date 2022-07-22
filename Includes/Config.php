<?php
  ob_start();
  session_start();
  $timezone = date_default_timezone_set("Europe/London");
  $con = mysqli_connect("mysql", "root", "MYSQLRand1_Pass2Stone3","quran");
  if(mysqli_connect_errno()){
    echo "Failed to Connect:" . mysqli_connect_errno();
  }

 ?>
