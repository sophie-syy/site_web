<?php
session_start();

include __DIR__ . "/../reutiliser/connecte_sql.php";

if (!isset($_SESSION['user']) || ($_SESSION['user']['is_admin'] ?? 0) != 1) {
    header('Location: /ue/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    echo "Requête invalide.";
    exit;
}

$id = (int) $_POST['id'];
if ($id <= 0) {
    echo "Identifiant de l'utilisateur invalide.";
    exit;
}

function rrmdir($dir) {
    if (!is_dir($dir)) return;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            rrmdir($path);
        } else {
            @unlink($path);
        }
    }
    @rmdir($dir);
}

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user) {
        $pdo->rollBack();
        echo "Utilisateur introuvable.";
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$id]);

    $pdo->commit();

    $uploadDir = __DIR__ . "/../../database/" . $id . '/';
    if (is_dir($uploadDir)) {
        rrmdir($uploadDir);
    }

    header('Location: utilisateur_.php');
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Erreur lors de la suppression : " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}
?>