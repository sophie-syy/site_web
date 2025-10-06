<?php
include __DIR__ . "/../reutiliser/connecte_sql.php";

$produits = $pdo->query('SELECT * FROM produit')->fetchAll();

include __DIR__ . "/../reutiliser/head.php";
include __DIR__ . "/../reutiliser/head_type.php";?>
<?php 
foreach ($produits as $produit) {
    $id = trim($produit['id'] ?? '');
    $type = trim($produit['type'] ?? '');
    $nom = trim($produit['nom'] ?? '');
    $commentaire = trim($produit['commentaire'] ?? '');
    $prix = trim($produit['prix'] ?? '');

    if($type == 'mousse-de-lait'){
        include __DIR__ . "/../reutiliser/command_aff.php";
    }
}
?>
</body>
</html>