<?php
/**
 * The following code registers a new user by creating an instance of the User class and calling its register method.
 */

// Include the User class
require_once 'backend/user.php';

// Create a new instance of the User class
$user = new User();

// Check if the 'register' POST variable is set and call the register method of the User class with the POST data
if(isset($_POST['register'])){
    echo $user->register($_POST);
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/login-register.css">
    <link rel="icon" type="image/x-icon" href="img/logo1.png">
  </head>
  <body>

  <main>
    	<section class="form">
	    	<form class="box" method="post">
        <!-- <img src="img/logo.png" width="200" alt="Logo"> -->
        <h1>Register</h1>
	    		<input type="text" name="voornaam" placeholder="Voornaam" required>
	    		<input type="text" name="tussenvoegsel" placeholder="tussenvoegsel" required>
	    		<input type="text" name="achternaam" placeholder="Achternaam" required>
	    		<input type="email" name="email" placeholder="Email" required>
	    		<input type="password" name="password" placeholder="Password" required>
	    		<input type="password" name="conf-password" placeholder="Password" required>
          <select name="option" class="pakket">
            <option name="" value=""></option>
            <option name="basis" value="1">medewerker</option>
            <option name="extra" value="2">eigenaar</option>
            <option name="platinum" value="3">klant</option>
          </select>
	    		<input type="submit" name="register" value="Register">
          <p class="login">
            Heb je al een account? <a href="login.php">Login hier</a>
          </p>
	    	</form>
    	</section>
    </main>



  </body>
</html>
