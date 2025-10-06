<?php
include __DIR__ . "/../reutiliser/connecte_sql.php"; 

$user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
$id = $_POST['product'] ?? null;

if ($user_id !== null) {
    $stmt = $pdo->prepare("DELETE FROM panier WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
} else {
    $stmt = $pdo->prepare("DELETE FROM panier WHERE id = ? AND user_id IS NULL");
    $stmt->execute([$id]);
}

include __DIR__ . "/p_paiment.php";
?>