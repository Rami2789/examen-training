<?php
require_once 'partial/header.php';
require_once 'class/post.php';
?>
<main>

<?php
$post = new Post();

if(isset($_POST['create'])){
	echo $post->createPosts($_POST);
}

?>

    	<section class="form">
	    	<form method="post">
				<input type="text" name="title" placeholder="Title" required>
	    		<input type="text" name="description" placeholder="Description" required>
	    		<input type="text" name="body" placeholder="Body" required>
				<select name="option" class="pakket" required>
					<option name="" value=""></option>
					<option name="basis" value="1">Rami</option>
					<option name="extra" value="2">Hanin</option>
					<option name="platinum" value="3">Joshua</option>
				</select>
	    		<input type="submit" name="create" value="Create">
	    	</form>
    	</section>
    </main>

	<?php require_once 'partial/footer.php'; ?>

