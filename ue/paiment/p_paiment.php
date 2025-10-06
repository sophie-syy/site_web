<?php
include __DIR__ . "/../reutiliser/connecte_sql.php";
include __DIR__ . "/../reutiliser/head.php";

// Récupérer l'id utilisateur
$user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

// Récupère le panier pour cet utilisateur
if ($user_id !== null) {
    $stmt = $pdo->prepare('SELECT * FROM panier WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $panier = $stmt->fetchAll();
} else {
    $panier = $pdo->query('SELECT * FROM panier WHERE user_id IS NULL')->fetchAll();
}

$total = 0;

foreach ($panier as $item) {
    $type = $item['type'];
    $nom = $item['nom'];
    $commentaire = $item['commentaire'];
    $prix = $item['prix'];
    $quantite = $item['quantité'];

    $total += $prix * $quantite;

    echo '<div class="rectangle">
           <div class=" en_ligne"> 
                <img width="80" height="80" src="/ue/image/';
                echo htmlspecialchars($type); echo'/';
                echo htmlspecialchars($nom); echo '.jpg" alt="">
                    <div class="_espace ">
                        <h2>'; echo htmlspecialchars($type); echo' ';
                            echo htmlspecialchars($nom); echo '</h2> 
                        <a>'; echo htmlspecialchars($commentaire); echo '</a>
                    </div>
            </div>
            <div class="en_ligne">
                <p class="centre_h">'; echo htmlspecialchars($quantite); echo'  x';
                echo htmlspecialchars($prix); echo '€ </p>
                <form class="centre_h _espace" action="/ue/paiment/f_enlever.php" method="post">
                    <input type="hidden" name="product" value="' . htmlspecialchars($item['id']) . '">
                    <input type="submit" class="color_r" value="Enlever" />
                </form>
            </div>
        </div>';
}
?>
<div class="total-bar">
    <span>Total: <span id="total-amount"><?php echo number_format($total, 2); ?> €</span></span>
    <form method="post" action="/ue/paiment/f_acheter.php" style="margin-right: 20px;">
        <input type="submit" class="button espace_" value="Acheter" />
    </form>
</div>
</body>
</html>


