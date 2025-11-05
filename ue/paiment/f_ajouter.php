<?php

include __DIR__ . "/../reutiliser/connecte_sql.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['product'] ?? '');
    $quantite = max(1, intval($_POST['quantite'] ?? 1));

    // Récupérer les infos du produit à partir de son id
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
    $stmt->execute([$id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérer l'id utilisateur
    $user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

    if ($produit) {
        // Vérifier si le produit existe déjà dans le panier pour cet utilisateur
        $check = $pdo->prepare("SELECT id, quantité FROM panier WHERE type = ? AND nom = ? AND user_id ".($user_id!==null?"= ?":"IS NULL"));
        $params = [$produit['type'], $produit['nom']];
        if ($user_id !== null) $params[] = $user_id;
        $check->execute($params);
        $item = $check->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Si déjà présent, augmenter la quantité
            $update = $pdo->prepare("UPDATE panier SET quantité = quantité + ? WHERE id = ?");
            $update->execute([$quantite, $item['id']]);
        } else {
            // Sinon, ajouter avec la quantité choisie
            $insert = $pdo->prepare("INSERT INTO panier (type, nom, commentaire, prix, quantité, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            $insert->execute([
                $produit['type'],
                $produit['nom'],
                $produit['commentaire'],
                $produit['prix'],
                $quantite,
                $user_id
            ]);
        }
    }
}

include __DIR__ . "/../command/p_command.php"; 
?>