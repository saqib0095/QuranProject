<?php 
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		  include("Includes/Config.php");
		  include("Includes/Classes/User.php");
		  include("Includes/Classes/Artist.php");
		  include("Includes/Classes/Album.php");
		  include("Includes/Classes/Surah.php");
		  include("Includes/Classes/Playlist.php");

		  if (isset($_GET['userLoggedIn'])) {
		  	$userLoggedIn = new User($con, $_GET['userLoggedIn']);
		  } else{
		  	echo "Username variable was not passed onto page.";
		  	exit; 
		  }
	}
	else {
		include("Includes/header.php");
		include("Includes/footer.php");
		$url = $_SERVER['REQUEST_URI'];
		echo "<script>
			openPage('$url');
		   </script>";
		   exit;

	}

 ?>