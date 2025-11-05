<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . "/../reutiliser/connecte_sql.php";

if (!isset($_SESSION['user']) || ($_SESSION['user']['is_admin'] ?? 0) != 1) {
    header('Location: /ue/index.php');
    exit;
}

$flash = $_SESSION['flash'] ?? [];
unset($_SESSION['flash']);

$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

$stmt = $pdo->query('SELECT * FROM produit ORDER BY id ASC');
$produits = $stmt->fetchAll();

include __DIR__ . "/../reutiliser/head.php";
include __DIR__ . "/../reutiliser/head_admin.php";
?>

<h2 class=" _espace">Liste des produits</h2>

<div>
    <form action="/ue/admin/produit_ajouter.php" method="post">
        <label class="_espace">Type:
            <input class="_espace" name="type" required value="<?= htmlspecialchars($old['type'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </label><br>
        <label class="_espace">Nom:
            <input class="_espace" name="nom" required value="<?= htmlspecialchars($old['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </label><br>
        <label class="_espace">Commentaire:
            <input class="_espace" name="commentaire" value="<?= htmlspecialchars($old['commentaire'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </label><br>
        <label class="_espace">Prix:
            <input class="_espace" name="prix" required value="<?= htmlspecialchars($old['prix'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </label><br>
        <button class="_espace" type="submit">Ajouter</button>
    </form>
</div>
<br>

<?php if (!empty($flash)): ?>
    <?php foreach ($flash as $f): ?>
        <?php
            $type = $f['type'] ?? 'info';
            $msg = $f['message'] ?? '';
            $style = ($type === 'success') ? 'background:#e54c41;padding:8px;'
                    : (($type === 'error') ? 'background:#e54c41;padding:8px;' : 'background:#e54c41;padding:8px;');
        ?>
        <p style="<?= $style ?>"><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<table cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>id</th>
            <th>Type</th>
            <th>Nom</th>
            <th>Commentaire</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($produits as $produit):
        $id = (int) ($produit['id'] ?? 0);
        $type = htmlspecialchars($produit['type'] ?? '', ENT_QUOTES, 'UTF-8');
        $nom = htmlspecialchars($produit['nom'] ?? '', ENT_QUOTES, 'UTF-8');
        $commentaire = htmlspecialchars($produit['commentaire'] ?? '', ENT_QUOTES, 'UTF-8');
        // Formatage du prix si numérique
        $rawPrix = $produit['prix'] ?? '';
        if (is_numeric($rawPrix)) {
            $prix = number_format((float)$rawPrix, 2, ',', ' ') . ' €';
        } else {
            $prix = htmlspecialchars($rawPrix, ENT_QUOTES, 'UTF-8');
        }
    ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $type ?></td>
            <td><?= $nom ?></td>
            <td><?= $commentaire ?></td>
            <td><?= $prix ?></td>
            <td>
                <form style="display:inline" action="/ue/admin/produit_edit.php" method="get">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit">Modifier</button>
                </form>

                <form style="display:inline" action="/ue/admin/produit_delete.php" method="post" 
                    onsubmit="return confirm('Confirmer la suppression du produit <?= addslashes($nom) ?> ?');">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>