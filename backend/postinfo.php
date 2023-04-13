<?php
require_once 'partial/header.php';
require_once 'class/Post.php';
?>



<?php
    $post = new Post();
    foreach ($post->getPostID($_GET["posts"]) as $post) { ?>
        <article>
            <p>Author: <?php echo $post->gebruikersnaam; ?></p>
            <p>Tietel: <?php echo $post->title; ?></p>
            <p>Description: <?php echo $post->description; ?></p>
            <p>Body: <?php echo $post->body; ?></p>
            <p>Created on: <?php echo $post->created_on; ?></p>
            <p>Updated on:<?php echo $post->updated_on; ?></p>
            <a href="postedit.php?posts=<?php echo $post->id ?>">Edit</a>
            <a href="postedit.php?posts=<?php echo $post->id ?>&delete=true">Delete</a>
        </article>
    <?php }
?>