<?php
  include("includes/config.php");
  include("includes/classes/Account.php");
  include("includes/classes/Constants.php");
  $account = new Account($con);
  include("includes/handlers/registerhandler.php");
  include("includes/handlers/loginhandler.php");

  function getInputValue($name){
    if(isset($_POST[$name])){
      echo $_POST[$name];
    }
  }
?>

<html>
  <head>
    <title>Quran</title>
    <link rel="stylesheet" href="Assets/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="Assets/js/register.js"> </script>
  </head>
  <body>
      <?php
      if(isset($_POST['Registerbutton'])){
        echo '<script>
          $(document).ready(function(){
          $("#loginform").hide();
            $("#registerForm").show();
        });
        </script>';
      } else {
        echo '<script>
          $(document).ready(function(){
            $("#loginform").show();
            $("#registerForm").hide();
        });
        </script>';

      }
      ?>

<div id = "background">
  <div id="loginContainer">
          <div id="inputContainer">
            <form id="loginform" action="register.php" method="POST">
              <h2>Login to Your Account</h2>
              <p>
              <?php echo $account->getError(Constants:: $loginfail);?>
              <label for="loginUsername">Username:</label>
              <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g saqib0095" value="<?php getInputValue('loginUsername') ?>"required>
              </p>
              <p>

              <label for="loginPassword">Password:</label>
              <input id="loginPassword" name="loginPassword" type="password" required>
            </p>
            <button type="submit" name="loginbutton">Login</button>
            <div class="hasAccountText">
              <span id="hideLogin"> Don't have an account yet? Signup here</span>
            </div>

            </form>

            <form id="registerForm" action="register.php" method="POST">
              <h2>Create your Free Account</h2>
              <p>
                <?php echo $account->getError(Constants::$usernameCharacters); ?>
                <?php echo $account->getError(Constants::$usernametaken);?>
                <label for="RegisterUsername">Username:</label>
                <input id="RegisterUsername" name="RegisterUsername" type="text" placeholder="e.g saqib0095" value="<?php getInputValue('RegisterUsername')?>" required>
              </p>

              <p>
                <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                <label for="Registerfirstname">First Name:</label>
                <input id="Registerfirstname" name="Registerfirstname" type="text" placeholder="e.g saqib" value="<?php getInputValue('Registerfirstname')  ?>" required>
              </p>

              <p>
                  <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                <label for="Registerlastname">Last Name:</label>
                <input id="Registerlastname" name="Registerlastname" type="text" placeholder="e.g masood"  value="<?php getInputValue('Registerlastname')  ?>" required>
              </p>

              <p>
                  <?php echo $account->getError(Constants::$emaildontmatch); ?>
                  <?php echo $account->getError(Constants::$emailinvalid); ?>
                  <?php echo $account->getError(Constants::$emailtaken);?>
                <label for="Registeremail">Email:</label>
                <input id="Registeremail" name="Registeremail" type="email" placeholder="e.g saqib_09@gmail.com" value="<?php getInputValue('Registeremail') ?>" required>
              </p>

              <p>

                <label for="Registeremail2">Confirm Email:</label>
                <input id="Registeremail2" name="Registeremail2" type="email" placeholder="e.g saqib_09@gmail.com" value="<?php getInputValue('Registeremail2') ?>" required>
              </p>

              <p>
                  <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                  <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                  <?php echo $account->getError(Constants::$passwordCharacters); ?>
              <label for="RegisterPassword">Password:</label>
              <input id="RegisterPassword" name="RegisterPassword" type="password"  required>
            </p>

            <p>

              <label for="RegisterPassword2">Confirm Password:</label>
              <input id="RegisterPassword2" name="RegisterPassword2" type="password"   required>
            </p>

            <button type="submit" name="Registerbutton"> Sign up </button>
            <div class="hasAccountText">
              <span id="hideRegister"> Already have an account? login in here </span>
            </div>
            </form>









          </div>
          <div id="logintext">
            <h1> Listen To Quran  </h1>
            <h2>Listen to Quran for free </h2>
            <ul>
              <li> Discover Quran</li>
              <li> Many reciters available</li>
              <li> Create Your own playlists </li>
            </ul>
          </div>


      </div>
</div>
  </body>
</html>
