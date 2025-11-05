<?php
include __DIR__ . "/../reutiliser/connecte_sql.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
    header('Location: /ue/index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $type = trim($_POST['type'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $commentaire = trim($_POST['commentaire'] ?? '');
    $prix = trim($_POST['prix'] ?? '');

    if ($id <= 0) {
        $error = 'Identifiant de produit invalide.';
    } elseif ($nom === '' || $type === '' || $prix === '') {
        $error = 'Veuillez renseigner le type, le nom et le prix.';
    } else {
        $prix_val = floatval(str_replace(',', '.', $prix));

        try {
            $stmt = $pdo->prepare('UPDATE produit SET type = :type, nom = :nom, commentaire = :commentaire, prix = :prix WHERE id = :id');
            $stmt->execute([
                ':type' => $type,
                ':nom' => $nom,
                ':commentaire' => $commentaire,
                ':prix' => $prix_val,
                ':id' => $id,
            ]);
            header('Location: /ue/admin/produit_.php');
            exit;
        } catch (Exception $e) {
            $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
        }
    }
} else {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    if ($id <= 0) {
        $error = 'Produit introuvable.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM produit WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $produit = $stmt->fetch();
        if (!$produit) {
            $error = 'Produit introuvable.';
        } else {
            $type = $produit['type'];
            $nom = $produit['nom'];
            $commentaire = $produit['commentaire'];
            $prix = $produit['prix'];
        }
    }
}

include __DIR__ . "/../reutiliser/head.php";
include __DIR__ . "/../reutiliser/head_admin.php";
?>

<h2 class=" _espace">Modifier le produit</h2>

<?php if ($error): ?>
    <div style="color:red;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="color:green;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (!isset($produit) && $_SERVER['REQUEST_METHOD'] !== 'POST' && $error): ?>
    <p><a href="/ue/admin/produits.php">Retour à la liste</a></p>
<?php else: ?>
    <form action="/ue/admin/produit_edit.php" method="post">
        <input type="hidden" name="id" value="<?= isset($id) ? (int)$id : 0 ?>">

        <label class=" _espace">
            Type:<br>
            <input class=" _espace" name="type" value="<?= htmlspecialchars($type ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </label>
        <br><br>

        <label class=" _espace">
            Nom:<br>
            <input class=" _espace" name="nom" value="<?= htmlspecialchars($nom ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </label>
        <br><br>

        <label class=" _espace">
            Commentaire:<br>
            <textarea class=" _espace" name="commentaire" rows="4" cols="40"><?= htmlspecialchars($commentaire ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </label>
        <br><br>

        <label class=" _espace">
            Prix:<br>
            <input class=" _espace" name="prix" value="<?= htmlspecialchars($prix ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </label>
        <br><br>

        <button class=" _espace" type="submit">Enregistrer</button>
        <a href="/ue/admin/produit_.php"><button type="button">Annuler</button></a>
    </form>
<?php endif; ?>