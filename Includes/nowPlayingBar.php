<?php
  $surahQuery = mysqli_query($con, "SELECT id FROM surah ORDER BY RAND() LIMIT 10");

  $resultArray = array();

  while ($row = mysqli_fetch_array($surahQuery)) {
    array_push($resultArray, $row['id']);
  }
 $jsonArray = json_encode($resultArray);
?>
<script>

$(document).ready(function(){
  var newPlaylist = <?php echo $jsonArray; ?>;
  audioElement = new Audio();
  setTrack(newPlaylist[0], newPlaylist,false);
  updateVolumeProgressBar(audioElement.audio);

  $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
    e.preventDefault();

  }); 



  $(".playbackBar .progressBar").mousedown(function(){
    mouseDown = true;
  });

   $(".playbackBar .progressBar").mousemove(function(e){
    if (mouseDown == true) {
      //set time of song depending position of mouse
      timeFromOffset(e, this);

    }
  });
   $(".playbackBar .progressBar").mouseup(function(e) {
    timeFromOffset(e, this);
  });

      $(".volumebar .progressBar").mousedown(function() {
    mouseDown = true;
  });

  $(".volumebar .progressBar").mousemove(function(e) {
    if(mouseDown == true) {

      var percentage = e.offsetX / $(this).width();

      if(percentage >= 0 && percentage <= 1) {
        audioElement.audio.volume = percentage;
      }
    }
  });

  $(".volumebar .progressBar").mouseup(function(e) {
    var percentage = e.offsetX / $(this).width();

    if(percentage >= 0 && percentage <= 1) {
      audioElement.audio.volume = percentage;
    }
  });


    $(document).mouseup(function(){
      mouseDown = false;
    });

});

  function timeFromOffset(mouse,progressBar){
    var percentage = mouse.offsetX / $(progressBar).width() * 100;
    var seconds = audioElement.audio.duration * (percentage/100);
    audioElement.setTime(seconds);

  }

  function prevSurah(){
    if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
      audioElement.setTime(0);

    }
    else{
      currentIndex = currentIndex -1;
      setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
  }
  function nextSurah(){
    if (repeat == true) {
      audioElement.setTime(0);
      playSurah();
      return;
    }
    if (currentIndex == currentPlaylist.length - 1 ) {
      currentIndex = 0;
    } else{
      currentIndex++;
    }

    var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay, currentPlaylist, true);
  }

  function setRepeat(){
    repeat = !repeat;
    //Swaping images if repeat is active
    var imageName = repeat ? "repeat-active.png" : "repeat.png";
    $(".controlButton.repeat img").attr("src","Assets/Images/icon/" + imageName);
  }
   function setMute(){
    audioElement.audio.muted = !audioElement.audio.muted;
    //Swaping images if repeat is active
    var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src","Assets/Images/icon/" + imageName);
  }
   function setshuffle(){
    shuffle = !shuffle;
    //Swaping images if repeat is active
    var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
    $(".controlButton.shuffle img").attr("src","Assets/Images/icon/" + imageName);
    if(shuffle == true){
      //Randomise playlist
      shuffleArray(shufflePlaylist);
      currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);

    }else{
      //shuffle has been deactivated
      currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);


    }
  }
  function shuffleArray(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

  function setTrack(trackId, newPlaylist, play){


    if(newPlaylist != currentPlaylist){
      //two copies of array, so we can go back to unshuffled array at any time.
      currentPlaylist = newPlaylist;
      shufflePlaylist = currentPlaylist.slice();
      shuffleArray(shufflePlaylist);
    }
    if(shuffle==true){
      currentIndex = shufflePlaylist.indexOf(trackId);
    }else{
      currentIndex = currentPlaylist.indexOf(trackId);

    }

    pauseSurah();

    $.post("Includes/handlers/ajax/getsurahjson.php", {surahid: trackId}, function(data){
      var track = JSON.parse(data);
      $(".trackName span").text(track.title);
        $.post("Includes/handlers/ajax/getArtistjson.php", {artistId: track.artist}, function(data){
          var artist = JSON.parse(data);
          $(".artistName span").text(artist.name);
          $(".artistName span").attr("onclick", "openPage('album.php?id="+ artist.id +"')");
          $(".trackName span").attr("onclick", "openPage('album.php?id="+ artist.id +"')");


        });

       

      audioElement.setTrack(track);
      if (play) {
        playSurah();
    }
     
    });

    
  }
  function playSurah(){
    if (audioElement.audio.currentTime == 0 ) {
       $.post("Includes/handlers/ajax/updatePlays.php", {surahid: audioElement.currentlyPlaying.id });

    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
  }


  function pauseSurah(){
      $(".controlButton.play").show();
      $(".controlButton.pause").hide();
      audioElement.pause();
  }

</script>


<div id="nowPlayingBarContainer">
  <div id="nowPlayingBar">
  <div id="nowPlayingLeft">
    <div class="content">
    
      <div class="trackInfo">
        <span class="trackName">
          <span role="link" tabindex="0" > </span>
          </span>

          <span class="artistName">
            <span role="link" tabindex="0"></span>
            </span>

      </div>


    </div>
  </div>


  <div id="nowPlayingCenter">
    <div class="content playerControls">
      <div class="buttons">
        <button class="controlButton shuffle" title="shuffle button" onclick="setshuffle()">
          <img src="Assets/Images/icon/shuffle.png" alt="shuffle">
        </button>

        <button class="controlButton previous" title="previous button" onclick="prevSurah()">
          <img src="Assets/Images/icon/previous.png" alt="previous">
        </button>

        <button class="controlButton play" title="play button" onclick="playSurah()">
          <img src="Assets/Images/icon/play.png" alt="play">
        </button>

        <button class="controlButton pause" title="pause button" style="display:none;" onclick="pauseSurah()">
          <img src="Assets/Images/icon/pause.png" alt="pause">
        </button>

        <button class="controlButton next" title="next button" onclick="nextSurah()">
          <img src="Assets/Images/icon/next.png" alt="next">
        </button>

        <button class="controlButton repeat" title="repeat button" onclick="setRepeat()">
          <img src="Assets/Images/icon/repeat.png" alt="repeat">
        </button>

        </div>
          <div class="playbackBar">
            <span class="progresstime current">0.00</span>
            <div class="progressBar">
              <div class="progressBarBg">
                <div class="progess"></div>

              </div>
            </d iv>
            <span class="progresstime remaining">0.00</span>
          </div>


      </div>

  </div>
  <div id="nowPlayingRight">
    <div class="volumebar">
      <button class="controlButton volume" title="volume button" onclick="setMute()">
        <img src="Assets/Images/icon/volume.png" alt="Volume">
      </button>
      <div class="progressBar">
        <div class="progressBarBg">
          <div class="progess"></div>

        </div>

    </div>
  </div>
  </div>

</div>
</div>
