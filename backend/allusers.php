<?php
require_once 'partial/header.php';
require_once 'class/post.php';
require_once 'class/user.php';
$user = new User();

?>

    <main>
      <section class="content">
          
        <?php foreach ($user->getUsers() as $userData) { ?>
          <article class="post">
            <h3><a href="userinfo.php?UserId=<?php echo $userData->id ?>"><?php echo $userData->voornaam; ?></a></h3>
            <?php echo $userData->tussenvoegsel . "<br>"; ?>
            <?php echo $userData->achternaam . "<br>"; ?>
            <a href="useredit.php?UserId=<?php echo $userData->id ?>">Edit</a>
            <a name="deletepost" href="useredit.php?UserId=<?php echo $userData->id ?>&delete=true" onclick="return deletePost();">Delete</a>

          </article>
        <?php } ?>
      </section>
    </main>