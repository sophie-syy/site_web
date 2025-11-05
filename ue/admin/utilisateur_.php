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

$stmt = $pdo->query('SELECT * FROM users ORDER BY id ASC');
$utilisateurs = $stmt->fetchAll();

include __DIR__ . "/../reutiliser/head.php";
include __DIR__ . "/../reutiliser/head_admin.php";
?>

<h2 class=" _espace">Liste des utilisateurs</h2>

<div>
    <form action="/ue/admin/utilisateur_ajouter.php" method="post">
        <label class="_espace">Nom :
            <input class="_espace" name="name" required value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </label><br>
        <label class="_espace">Email :
            <input class="_espace" name="email" required value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </label><br>
        <label class="_espace">Mot de passe :
            <input class="_espace" name="password" type="password" required>
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
            <th>Nom</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($utilisateurs as $utilisateur):
        $id = (int) ($utilisateur['id'] ?? 0);
        $nom = htmlspecialchars($utilisateur['name'] ?? '', ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($utilisateur['email'] ?? '', ENT_QUOTES, 'UTF-8');
    ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $nom ?></td>
            <td><?= $email ?></td>
            <td>
                <form style="display:inline" action="/ue/admin/utilisateur_edit.php" method="get">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit">Modifier</button>
                </form>

                <form style="display:inline" action="/ue/admin/utilisateur_delete.php" method="post" 
                    onsubmit="return confirm('Confirmer la suppression de l\'utilisateur <?= addslashes($nom) ?> ?');">
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