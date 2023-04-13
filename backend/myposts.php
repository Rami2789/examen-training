<?php
require_once 'partial/header.php';
require_once 'class/post.php';
require_once 'class/user.php';
$post = new Post();

?>

    <main>
      <section class="content">
        <?php foreach ($post->getPostFromUser($_SESSION['id']) as $postData) { ?>
            <article class="post">
                <h3><a href="postinfo.php?posts=<?php echo $postData->id ?>"><?php echo $postData->title; ?></a></h3>
                <?php echo $postData->description . "<br>"; ?>
                <?php echo $postData->body . "<br>"; ?>
                <a href="postedit.php?posts=<?php echo $postData->id ?>">Edit</a>
                <a href="postedit.php?posts=<?php echo $postData->id ?>&delete=true" onclick="return confirmDelete();">Delete</a>
            </article>
        <?php } ?>
      </section>
    </main>

<script src="../js/posts.js"></script>