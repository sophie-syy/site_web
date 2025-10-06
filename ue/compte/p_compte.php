<?php
include __DIR__ . "/../reutiliser/head.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'];
?>

<div class="centre_l">
    <h2 class="_espace">Mon compte</h2>
    <p><strong class="_espace">Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
    <p><strong class="_espace">Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <br>
    <div class="en_ligne">
        <form action="/ue/compte/f_vider.php" method="post">
            <input class="_espace color_r" type="submit" value="Déconnecter" />
        </form>
        <form action="/ue/compte/f_suprimer.php" method="post">
            <input class="_espace color_r" type="submit" value="Suprimer" />
        </form>
    </div>
</div>

</body>
</html>