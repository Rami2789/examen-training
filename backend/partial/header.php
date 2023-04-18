<?php

session_start();
if(isset($_SESSION['ingelogd']) && $_SESSION['ingelogd'] === true) {
    if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        ?>
        <a href="admin-dashboard.php">Home</a>
        <a href="createuser.php">Create User</a>
        <a href="createpost.php">Create Posts</a>
        <a href="myposts.php">My Posts</a>
        <a href="allposts.php">All Posts</a>
        <a href="allusers.php">All Users</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
        <?php
    } else if(isset($_SESSION['eigenaar']) && $_SESSION['eigenaar'] === true) {
        ?>
        <a href="eigenaar-dashboard.php">Home</a>
        <a href="createuser.php">Create User</a>
        <a href="createpost.php">Create Posts</a>
        <a href="myposts.php">My Posts</a>
        <a href="allposts.php">All Posts</a>
        <a href="allusers.php">All Users</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
        <?php
    } else {
        ?>
        <a href="user-dashboard.php">Home</a>
        <a href="allposts.php">All posts</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
        <?php
    } 
} else {
    header("Location: ../login.php");
}
?>