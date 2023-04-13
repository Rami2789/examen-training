<?php
require_once 'class/user.php';

$update = new User();

if (isset($_POST['update'])) {
    $update->userUpdate($_POST);
}

if (isset($_POST["delete"])) {
    $update->deleteUser($_POST['id']);
    header("Location: ../login.php");
}

session_start();
if(!$_SESSION['ingelogd']|| !$_SESSION['ingelogd']){
    header("Location: ../login.php");
}


$user = $update->getUserData($_SESSION['id']);


?>

        <section class="profile">
        <?php
           foreach ($update->getUserData($_SESSION['id']) as $users) {
        ?>
            <form class="item-info" method="post">
                <article  class="item-info1">
                    <p>voornaam</p>
                    <input type="text" value='<?php echo $users->voornaam;?>' name="voornaam" placeholder="voornaam">
                    <p>Tussenvoegsel</p>
                    <input type="text" value='<?php echo $users->tussenvoegsel;?>' name="tussenvoegsel" placeholder="Tussenvoegsel">
                    <p>Achternaam</p>
                    <input type="text" value='<?php echo $users->achternaam;?>' name="achternaam" placeholder="Achternaam">
                </article>
                <article class="item-info2">
                    <p>Email</p>
                    <input type="text" value='<?php echo $users->email;?>' name="email" placeholder="Email">
                    <p>Wachtwoord</p>
                    <input type="password" name="password" placeholder="Password">
                    <input type="hidden" name="id" value="<?php echo $users->id; ?>">
                    <input type="submit" name="update" value="Update">
                    <input type="submit" name="delete" value="Delete" onclick="return confirmDelete();">
                </article>
            </form>
            <?php } ?>
        </section>


        <!-- <section class="profile">
            <form class="item-info" method="post">
                <article  class="item-info1">
                    <p>voornaam</p>
                    <input type="text" value='<?php echo $user[0]->voornaam;?>' name="voornaam" placeholder="voornaam">
                    <p>Tussenvoegsel</p>
                    <input type="text" value='<?php echo $user[0]->tussenvoegsel;?>' name="tussenvoegsel" placeholder="Tussenvoegsel">
                    <p>Achternaam</p>
                    <input type="text" value='<?php echo $user[0]->achternaam;?>' name="achternaam" placeholder="Achternaam">
                </article>
                <article class="item-info2">
                    <p>Email</p>
                    <input type="text" value='<?php echo $user[0]->email;?>' name="email" placeholder="Email">
                    <p>Wachtwoord</p>
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" name="update" value="Update">
                </article>
            </form>
        </section> -->

<script src="../js/profile.js"></script>
