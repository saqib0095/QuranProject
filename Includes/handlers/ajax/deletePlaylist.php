<?php 
include("../../config.php");
if (isset($_POST['playlistId'])) {
	$playlistId = $_POST['playlistId'];
	$PlaylistQuery = mysqli_query($con,"DELETE FROM playlist WHERE id ='$playlistId'");
	$SongsQuery = mysqli_query($con,"DELETE FROM playlistSurahs WHERE playlistid ='$playlistId'");


}else{
	echo "Playlist id was not passed into delete Playlist.php";
}

 ?>