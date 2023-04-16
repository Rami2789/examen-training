<?php
session_start();
if(isset($_SESSION['ingelogd']) && $_SESSION['ingelogd'] === true) {
    if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        ?>
        <a href="index.php">Home</a>
        <a href="createpost.php">Create posts</a>
        <a href="myposts.php">My Posts</a>
        <a href="allposts.php">All posts</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
        <?php
    } else {
        ?>
        <a href="posts.php">Posts</a>
        <a href="logout.php">Logout</a>
        <?php
    } 
} else {
    header("Location: ../login.php");
    exit();
}
?>
