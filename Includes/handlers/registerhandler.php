 <?php
function sanitizeFormUsername($inputText){
  $inputText = strip_tags($inputText);
  $inputText = str_replace(" ", "", $inputText);
  return $inputText;
}

function sanitizeFormString($inputText){
  $inputText = strip_tags($inputText);
  $inputText = str_replace(" ", "", $inputText);
  $inputText = ucfirst(strtolower($inputText));
  return $inputText;
}
function sanitizeFormPassword($inputText){
  $inputText = strip_tags($inputText);
  return $inputText;
}




if(isset($_POST['Registerbutton'])) {
  //register button was pressed
  $username = sanitizeFormUsername($_POST['RegisterUsername']);
  $firstname = sanitizeFormString($_POST['Registerfirstname']);
  $lastname = sanitizeFormString($_POST['Registerlastname']);
  $Email = sanitizeFormString($_POST['Registeremail']);
  $confirmemail = sanitizeFormString($_POST['Registeremail2']);
  $password = sanitizeFormPassword($_POST['RegisterPassword']);
  $password2 = sanitizeFormPassword($_POST['RegisterPassword2']);

  $wassuccessful = $account->register($username,$firstname,$lastname,$Email,$confirmemail,$password,$password2);

  if($wassuccessful == true) {
    $_SESSION['userLoggedIn'] = $username;
    header("Location: index.php");

  }

}





 ?>
