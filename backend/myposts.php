<?php
require_once 'partial/header.php';
require_once 'class/post.php';
require_once 'class/user.php';
$post = new Post();

if (isset($_GET['delete'])) {
  $user->deletePost(isset($_POST['delete']) || $_GET['posts']);
  header("Location: myposts.php");
}
?>

    <main>
      <section class="content">
        <?php foreach ($post->getPostFromUser($_SESSION['id']) as $postData) { ?>
            <article class="post">
                <h3><a href="postinfo.php?posts=<?php echo $postData->id ?>"><?php echo $postData->title; ?></a></h3>
                <?php echo $postData->description . "<br>"; ?>
                <?php echo $postData->body . "<br>"; ?>
                <a href="postedit.php?posts=<?php echo $postData->id ?>">Edit</a>
                <a name="deletepost" href="postedit.php?posts=<?php echo $postData->id ?>&delete=true" onclick="return deletePost();">Delete</a>
            </article>
        <?php } ?>
      </section>
    </main>

<script src="../js/posts.js"></script>