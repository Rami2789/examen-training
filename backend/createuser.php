<?php
require_once "partial/header.php";

/**
 * The following code registers a new user by creating an instance of the User class and calling its register method.
 */

// Include the User class
require_once 'class/user.php';

// Create a new instance of the User class
$user = new User();

// Check if the 'register' POST variable is set and call the register method of the User class with the POST data
if(isset($_POST['register'])){
    echo $user->createUser($_POST);
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Create User</title>
    <link rel="stylesheet" href="css/login-register.css">
    <link rel="icon" type="image/x-icon" href="img/logo1.png">
  </head>
  <body>

  <main>
    	<section class="form">
	    	<form class="box" method="post">
        <h1>Create User</h1>
	    		<input type="text" name="voornaam" placeholder="Voornaam" required>
	    		<input type="text" name="tussenvoegsel" placeholder="tussenvoegsel" required>
	    		<input type="text" name="achternaam" placeholder="Achternaam" required>
	    		<input type="email" name="email" placeholder="Email" required>
	    		<input type="password" name="password" placeholder="Password" required>
	    		<input type="password" name="conf-password" placeholder="Password" required>
          <!-- <select name="option" class="pakket">
                <option name="" value=""></option>
                <option name="basis" value="1">medewerker</option>
                <option name="extra" value="2">klant</option>
                <option name="platinum" value="3">eigenaar</option>
          </select> -->
	    		<input type="submit" name="register" value="Register">
	    	</form>
    	</section>
    </main>



  </body>
</html>
