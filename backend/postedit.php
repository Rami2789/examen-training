<?php
require_once 'partial/header.php';
require_once 'class/Post.php';

$post = new Post();
if (isset($_POST['update'])) {
    $post->editpost($_POST, $_GET['posts']);
}

if (isset($_POST['delete']) || isset($_GET['delete'])) {
    $post->deletePost($_POST, $_GET['posts']);
    header("Location: myposts.php");
}
?>



<?php

    foreach ($post->getPostID($_GET["posts"]) as $post) { ?>
        <article>
            <form method="post">
            <input type="text" name="title" value="<?php echo $post->title; ?>">
            <input type="text" name="description" value="<?php echo $post->description; ?>">
            <input type="text" name="body" value="<?php echo $post->body; ?>">
            <select name="option" class="pakket" required>
                <option name="Geen voorkeur" value="Geen voorkeur">Geen voorkeur</option>
                <option name="basis" value="1">Rami</option>
                <option name="extra" value="2">Hanin</option>
                <option name="platinum" value="3">Joshua</option>
			</select>
            <input type="submit" name="update" value="Update">
            <input type="submit" name="delete" value="delete" onclick="return confirmDelete();">
            </form>
        </article>
    <?php }
?>

<script src="../js/posts.js"></script>

