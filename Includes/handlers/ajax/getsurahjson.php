<?php
  include("../../Config.php");

  if (isset($_POST['surahid'])) {
    $surahId = $_POST['surahid'];

    $query = mysqli_query($con,"SELECT * FROM surah WHERE id='$surahId'");
    $resultArray = mysqli_fetch_array($query);

    echo json_encode($resultArray);

  }

?>
