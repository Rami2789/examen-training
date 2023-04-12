<?php

session_start();
if(!$_SESSION['ingelogd']){
    header("Location: login.php");
}
?>


<a href="logout.php">Logout</a>