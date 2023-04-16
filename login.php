<?php
require_once "partial/header.php";

/**
 * Includes the necessary files and creates a User object.
 */
require_once 'backend/class/user.php';
$user = new User();

/**
 * Checks if the login form has been submitted and calls the login method of the User object.
 *
 * @param array $_POST The POST request data sent from the login form.
 *
 * @return string Returns the output of the login method.
 */
if (isset($_POST['login'])) {
  echo $user->login($_POST);
}

if (isset($_SESSION['ingelogd'])) {
  if (isset($_SESSION['admin'])) {
    header("Location: backend/admin-dashboard.php");
  } elseif (isset($_SESSION['eigenaar'])) {
    header("Location: backend/eigenaar-dashboard.php");
  } else {
    header("Location: backend/user-dashboard.php");
  }
  exit();
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login-register.css">
    <link rel="icon" type="image/x-icon" href="img/logo1.png">
  </head>
  <body>
            <form class="box" method="post">
                <!-- <img src="img/logo.png" width="200" alt="Logo"> -->
                <h1>Login</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="login" value="Login">
                <p class="login">
                  Nieuw? <a href="register.php">Registreer hier</a>
                </p>
            </form>
  </body>
</html>
