<?php
require_once 'partial/header.php';
require_once 'backend/class/post.php';
require_once 'backend/class/user.php';
$post = new Post();

?>

    <main>
      <section class="content">
          
        <?php foreach ($post->getPost() as $postData) { ?>
          <article class="post">
            <h3><a href="postinfo.php?posts=<?php echo $postData->id ?>"><?php echo $postData->title; ?></a></h3>
            <?php echo $postData->description . "<br>"; ?>
            <?php echo $postData->body . "<br>"; ?>
          </article>
        <?php } ?>
      </section>
    </main>