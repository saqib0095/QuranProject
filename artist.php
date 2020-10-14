<?php 
	include("includes/includedfiles.php");
	if (isset($_GET['id'])) {
	  $artistid = $_GET['id'];
	}
	else {
	  header("Location: index.php");
	}

	$artist = new Artist($con, $artistid);

 ?>

 <div class="entityInfo borderBottom">
 	<div class="centerSection">
 		
 		<div class="artistInfo">
 			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>
 			<div class="headerButtons">
 				<button class="button green" onclick="playFirstSurah()">Play</button>
 			</div>
 		</div>
 	</div>
 	

 </div>
 <div class="tracklistContainer borderBottom">
 	<h2>SURAHS</h2>
  <ul class="tracklist">

      <?php
      $surahIdArray = $artist->getSurahIds();
      $i = 1;
      foreach($surahIdArray as $surahId) {
      	if ($i > 5) {
      		break;
      	}
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
<div class="gridViewContainer">
	<h2>ALBUMS YOU MIGHT LIKE</h2>
	    <?php
	  $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist!='$artistid' ORDER BY RAND() LIMIT 5");

	  while($row = mysqli_fetch_array($albumQuery)) {
	    echo "<div class='gridViewItem'>
	     <span  role='link' tabindex='0' onclick='openPage(\"album.php?id=". $row['id'] ."\")' >
	        <img src='".$row['artworkpath'] ."'>
	          <div class='gridViewInfo'>
	          ". $row['title'] . "
	          </div>
	          </span>
	    </div>";
	  }
	?>

  </div>