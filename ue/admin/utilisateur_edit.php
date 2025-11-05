<?php
session_start();

include __DIR__ . "/../reutiliser/connecte_sql.php";

if (!isset($_SESSION['user']) || ($_SESSION['user']['is_admin'] ?? 0) != 1) {
    header('Location: /ue/index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Charge l'utilisateur actuel pour le hash existant
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch();

    if (!$user) {
        $error = 'Utilisateur introuvable.';
    } elseif ($name === '' || $email === '') {
        $error = 'Veuillez renseigner le nom et l\'email.';
    } else {
        // Si nouveau mot de passe : hash, sinon conserve le hash actuel
        if ($password !== '') {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $password_hash = $user['password_hash'];
        }

        try {
            $stmt = $pdo->prepare('UPDATE users SET name = :name, email = :email, password_hash = :password_hash WHERE id = :id');
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password_hash' => $password_hash,
                ':id' => $id,
            ]);
            header('Location: /ue/admin/utilisateur_.php');
            exit;
        } catch (Exception $e) {
            $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
        }
    }
} else {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    if ($id <= 0) {
        $error = 'Utilisateur introuvable.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        if (!$user) {
            $error = 'Utilisateur introuvable.';
        } else {
            $name = $user['name'];
            $email = $user['email'];
        }
    }
}

include __DIR__ . "/../reutiliser/head.php";
include __DIR__ . "/../reutiliser/head_admin.php";
?>

<h2 class=" _espace">Modifier l'utilisateur</h2>

<?php if ($error): ?>
    <div style="background:#ffe6e6;border:1px solid #d9534f;padding:8px;margin-bottom:8px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="background:#e6ffea;border:1px solid #5cb85c;padding:8px;margin-bottom:8px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<form action="/ue/admin/utilisateur_edit.php" method="post">
    <input type="hidden" name="id" value="<?= isset($id) ? (int)$id : 0 ?>">

    <label class=" _espace">
        Nom :<br>
        <input class=" _espace" name="name" value="<?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
    </label>
    <br><br>

    <label class=" _espace">
        Email :<br>
        <input class=" _espace" name="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
    </label>
    <br><br>

    <label class=" _espace">
        Mot de passe :<br>
        <input class=" _espace" name="password" type="password">
    </label>
    <br><br>

    <button class=" _espace" type="submit">Enregistrer</button>
    <a href="/ue/admin/utilisateur_.php"><button type="button">Annuler</button></a>
</form>