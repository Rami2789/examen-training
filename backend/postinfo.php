<?php
    require_once 'partial/header.php';
    require_once 'class/post.php';
    $post = new Post();
    if(isset($_POST['create'])){
        echo $post->comment($_POST);
    }
?>



<?php
    foreach ($post->getPostID($_GET["posts"]) as $post) { ?>
        <article>
            <p>Author: <?php echo $post->gebruikersnaam; ?></p>
            <p>Tietel: <?php echo $post->title; ?></p>
            <p>Description: <?php echo $post->description; ?></p>
            <p>Body: <?php echo $post->body; ?></p>
            <p>Created on: <?php echo $post->created_on; ?></p>
            <p>Updated on:<?php echo $post->updated_on; ?></p>
        </article>
    <?php }
?>


<section class="form">
        <form method="post">
        <input type="text" name="naam" placeholder="Naam" required>
        <input type="text" name="message" placeholder="Message" required>
        <input type="number" name="postId" value="<?php echo $_GET['posts'] ?>" readonly hidden>
        <input type="submit" name="create" value="Comment">
        </form>
</section>

<main>
    <section class="content">
        <?php 
            $post = new Post();
            foreach ($post->getComments($_GET["posts"]) as $postData) { ?>
            <article class="post">
                <?php echo $postData->author . "<br>"; ?>
                <?php echo $postData->message . "<br>"; ?>
            </article>
        <?php } ?>
    </section>
</main>