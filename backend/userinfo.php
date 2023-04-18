<?php
require_once 'partial/header.php';
require_once 'class/user.php';

$user = new User();

if (isset($_GET['UserId'])) {
    $userData = $user->getUserById($_GET['UserId']);
}
?>

<main>
    <section class="content">
        <article>
            <h2>User Details</h2>
            <p><strong>Name:</strong> <?php echo $userData->voornaam.' '.$userData->tussenvoegsel.' '.$userData->achternaam; ?></p>
            <p><strong>Gebruikersnaam:</strong> <?php echo $userData->gebruikersnaam; ?></p>
            <p><strong>Email:</strong> <?php echo $userData->email; ?></p>
            <p><strong>Rol:</strong> <?php echo $userData->rollenid; ?></p>
        </article>
    </section>
</main>

<?php
require_once 'partial/footer.php';
?>
