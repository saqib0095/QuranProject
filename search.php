<?php 
	include("includes/includedfiles.php");
	if(isset($_GET['term'])){
		$term = urldecode($_GET['term']);

	}
	else{
		$term = "";
	}


 ?>
 <div class="searchContainer">
 	
 	<h4>Search for an Reciter or Surah</h4>
 	<input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start Typing..." onfocus="var val=this.value; this.value=''; this.value= val; ">
 </div>
 <script>
 	$(".searchInput").focus();
 	$(function(){
 		
 		$(".searchInput").keyup(function(){
 			clearTimeout(timer);

 			timer = setTimeout(function(){
 				var val = $(".searchInput").val();
 				openPage("search.php?term=" + val);
 			},1000)
 		});
 	});

 </script>
 <?php if ($term == "") {
 	exit();
 } 
 ?>

  <div class="tracklistContainer borderBottom">
 	<h2>SURAHS</h2>
  <ul class="tracklist">

      <?php
      //$term% means will return any word after the term ie garden , will return anything after the word garden.
      $surahsQuery = mysqli_query($con, "SELECT id FROM surah WHERE title LIKE '%$term%' LIMIT 10");
      if (mysqli_num_rows($surahsQuery)==0) {
      	echo "<span class='noResults'>No Surah's Found: " . $term . "</span>";
      }
      $surahIdArray = array();
      $i = 1;
      while($row = mysqli_fetch_array($surahsQuery)) {
      	if ($i > 15) {
      		break;
      	}
      	array_push($surahIdArray, $row['id']);
        $albumSurah = new Surah($con, $row['id']);

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
	<h2>Reciters </h2>
	    <?php
	  $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '%$term%' LIMIT 10");
	  if (mysqli_num_rows($albumQuery)==0) {
	  	echo "<span class='noResults'> No Reciters found: " . $term . "</span>";
	  }
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