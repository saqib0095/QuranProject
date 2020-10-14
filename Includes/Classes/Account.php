<?php

class Account{
  private $con;

  private $errorArray;

  public function  __construct($con) {
    $this->con = $con;
    $this->errorArray = array();
  }

  public function login($un,$ps){
    $ps = md5($ps);
    $query = mysqli_query($this->con, "SELECT * FROM users WHERE username = '$un' AND password = '$ps'");

    if(mysqli_num_rows($query) == 1){
      return true;
    } else{
      array_push($this->errorArray, Constants:: $loginfail);
      return false;
    }

  }
  public function getError($error) {
    if(!in_array($error, $this->errorArray)){
      $error = "";

    }
    return "<span class='errorMessage'>$error</span>";
  }

  public function register($un,$fn,$ln,$en,$en2,$ps,$ps2){
    $this->validateUsername($un);
    $this->validateFirstname($fn);
    $this->validateLastname($ln);
    $this->validateEmails($en,$en2);
    $this->validatePasswords($ps,$ps2);

    if(empty($this->errorArray) == true ){
      //insert into db
      return $this->insertuserdetails($un,$fn,$ln,$en,$ps);
    }
    else{
      return false;
    }
  }
  private function insertuserdetails($un,$fn,$ln,$en,$ps){
    $encrypterPs = md5($ps); //password return long letters encrypted
    $profilePic = "Assets/Images/profile-pics/gtr.jpg";
    $date = date("Y-m-d");

    $result= mysqli_query($this->con, "INSERT INTO users VALUES ('','$un','$fn','$ln','$en','$encrypterPs','$date','$profilePic')");
    return $result;
  }



    private function validateUsername($un) {
      if(strlen($un) > 25 || strlen($un) < 5) {
        array_push($this->errorArray, Constants::$usernameCharacters);
        return;
      }
      //TODO: check if user exist.
      $checkUsername = mysqli_query($this->con, "SELECT username FROM users WHERE username = '$un'");
      if(mysqli_num_rows($checkUsername)!=0){
        array_push($this->errorArray, Constants::$usernametaken);
        return;
      }
    }
    private function validateFirstname($fn){
      if(strlen($fn) > 25 || strlen($fn) < 5){
        array_push($this->errorArray, Constants::$firstNameCharacters);
        return;
      }
    }
    private function validateLastname($ln){
      if(strlen($ln) > 25 || strlen($ln) < 5){
        array_push($this->errorArray, Constants::$lastNameCharacters);
        return;
      }
    }
    private function validateEmails($en,$en2){
      if($en != $en2){
        array_push($this->errorArray, Constants::$emaildontmatch);
        return;
      }
      if(!filter_var($en,FILTER_VALIDATE_EMAIL)){
        array_push($this->errorArray, Constants::$emailinvalid);
        return;
      }

      $checkemail = mysqli_query ($this->con, "SELECT email FROM users WHERE email ='$en'");
      if(mysqli_num_rows($checkemail) !=0){
        array_push($this->errorArray, Constants::$emailtaken);
        return;
      }
    }
    private function validatePasswords($ps,$ps2){
      if($ps != $ps2){
        array_push($this->errorArray, Constants::$passwordsDoNotMatch);
        return;
      }
      if(preg_match('/[^A-Za-z0-9]/',$ps)){
        array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
        return;
      }
      if(strlen($ps) > 25 || strlen($ps) < 5){
        array_push($this->errorArray, Constants::$passwordCharacters);
        return;
      }

    }
}

  ?>
