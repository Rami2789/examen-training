<?php

session_start();
if(!$_SESSION['ingelogd']){
    header("Location: ../login.php");
}
?>


<a href="index.php">Home</a>
<a href="createpost.php">Create posts</a>
<a href="myposts.php">My Posts</a>
<a href="allposts.php">All posts</a>
<a href="profile.php">Profile</a>
<a href="logout.php">Logout</a>