<?php
  include("Includes/Config.php");
  include("Includes/Classes/Artist.php");
  include("Includes/Classes/Album.php");
  include("Includes/Classes/Surah.php");


  //session_destroy(); // logout manually
  if(isset($_SESSION['userLoggedIn'])){
    $userLoggedIn = $_SESSION['userLoggedIn'];
    echo "<script> userLoggedIn = '$userLoggedIn'; </script>";

  }else {
    header("Location: register.php");
  }
?>




<html>
  <head>

    <title>Quran</title>
    <link rel="stylesheet" href="Assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="Assets/js/script.js"></script>
  </head>

  <body>

    <div id="mainContainer">
      <div id="topContainer">
        <?php include("Includes/navBarContainer.php"); ?>
        <div id="mainViewContainer">
          <div id="mainContent">
