<?php
require_once 'partial/header.php';
require_once 'class/user.php';

$user = new User();

if (isset($_GET['UserId'])) {
    $userData = $user->getUserById($_GET['UserId']);
}

if (isset($_POST['update'])) {
    $user->userUpdateEigenaar($_POST);
    header("Location: useredit.php?UserId=".$_POST['userId']);
}

if (isset($_GET['delete'])) {
    $user->deleteUser(isset($_POST['delete']) || $_GET['UserId']);
    header("Location: allusers.php");
}

?>

<main>
    <section class="content">
        <article>
            <form method="post">
                <input type="text" name="voornaam" value="<?php echo $userData->voornaam; ?>">
                <input type="text" name="tussenvoegsel" value="<?php echo $userData->tussenvoegsel; ?>">
                <input type="text" name="achternaam" value="<?php echo $userData->achternaam; ?>">
                <input type="text" name="gebruikersnaam" value="<?php echo $userData->gebruikersnaam; ?>">
                <input type="email" name="email" value="<?php echo $userData->email; ?>">
                <input type="hidden" name="userId" value="<?php echo $userData->id; ?>">
                <select name="option" class="pakket" required>
                    <option name="Medewerker" value="2" <?php if ($userData->rollenid == '2') { echo 'selected'; } ?>>Medewerker</option>
                    <option name="Klant" value="3" <?php if ($userData->rollenid == '3') { echo 'selected'; } ?>>Klant</option>
                </select>
                <input type="submit" name="update" value="Update">
            </form>
        </article>
    </section>
</main>

<script src="../js/posts.js"></script>

<?php
require_once 'partial/footer.php';
?>
