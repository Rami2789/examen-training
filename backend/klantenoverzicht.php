<?php
require_once 'partial/header.php';
require_once 'class/post.php';
require_once 'class/user.php';
$user = new User();
if (isset($_GET['delete'])) {
    $user->deleteUser(isset($_POST['delete']) || $_GET['UserId']);
    header("Location: allusers.php");
}
?>

<main>
    <section class="content">
        <h1>All Klanten</h1>
        <?php foreach ($user->getUserDataByRollenid(3) as $userData) { ?>
            <article class="post">
            <h3><a href="userinfo.php?UserId=<?php echo $userData->id ?>"><?php echo $userData->voornaam; ?></a></h3>
            <?php echo $userData->tussenvoegsel . "<br>"; ?>
            <?php echo $userData->achternaam . "<br>"; ?>
            <a href="useredit.php?UserId=<?php echo $userData->id ?>">Edit</a>
            <a name="deletepost" href="klantenoverzicht.php?UserId=<?php echo $userData->id ?>&delete=true" onclick="return deletePost();">Delete</a>

            </article>
        <?php } ?>
    </section>
</main>