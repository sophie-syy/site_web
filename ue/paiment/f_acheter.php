<?php
include __DIR__ . "/../reutiliser/connecte_sql.php";


if (!isset($_SESSION['user'])) {
    include __DIR__ . "/../compte/p_connecter.php";
    echo "<div class='text-center'>
    Veuillez vous connecter pour finaliser votre achat.</div>";
    exit;
}

// Vider le panier
$pdo->query("DELETE FROM panier");

include __DIR__ . "/../reutiliser/head.php";
?>

<div class="centre_l text-center">
    <h2 class="_espace">Achat effectué !</h2>
    <p>Merci pour votre commande.</p>
    <a href="/ue/index.php" class="button">Retour à l'accueil</a>
</div>
</body>
</html>
