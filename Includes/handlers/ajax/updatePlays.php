<?php
  include("../../config.php");

  if (isset($_POST['surahid'])) {
    $surahid = $_POST['surahid'];

    $query = mysqli_query($con,"UPDATE surah SET plays = plays + 1 WHERE id='$surahid'");
    

  }

?>