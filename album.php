<?php 
include("Includes/includedfiles.php");
if (isset($_GET['id'])) {
  $albumid = $_GET['id'];
}
else {
  header("Location: index.php");
}

$album = new Album($con,$albumid);
$artist = $album->getArtist();



 ?>

<div class="entityInfo">
  <div class="leftSection">
    <img src="<?php echo $album->getArtwork(); ?>">
  </div>

  <div class="rightSection">
    <h2><?php echo $album->getTitle();?> </h2>
    <p>By <?php echo $artist->getName(); ?> </p>
    <p> <?php echo $album->getNumberOfSongs(); ?> Surahs</p>
  </div>

</div>

<div class="tracklistContainer">
  <ul class="tracklist">

      <?php
      $surahIdArray = $album->getSurahIds();
      $i = 1;
      foreach($surahIdArray as $surahId) {
        $albumSurah = new Surah($con, $surahId);

        $albumArtist = $albumSurah->getArtist();

        echo "<li class='tracklistrow'>
        <div class='trackCount'>
          <img class='play' src='Assets/Images/icon/play-white.png' onclick='setTrack(\"". $albumSurah->getId() ."\", tempPlaylist,true)'>
          <span class='trackNumber'> $i  </span>
        </div>
        <div class='trackInfo'>
        <span class='trackName'>" . $albumSurah->getTitle() . "</span>
        <span class='artistName'>" . $albumArtist->getName() . " </span>
        </div>
        <div class='trackOptions'>
          <img class='optionsButton' src='Assets/Images/icon/more.png'>
        </div>
        <div class='trackDuration'>
        <span class='duration'> ". $albumSurah->getDuration() . " </span>
        </div>
        </li>";

        $i++;

      }

      ?>
      <script>
        var tempSurahIds = '<?php echo json_encode($surahIdArray); ?>';
        tempPlaylist = JSON.parse(tempSurahIds);


      </script>


  </ul>

</div>




