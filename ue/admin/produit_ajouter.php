<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . "/../reutiliser/connecte_sql.php";

if (!isset($_SESSION['user']) || ($_SESSION['user']['is_admin'] ?? 0) != 1) {
    header('Location: /ue/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /ue/admin/produit_.php');
    exit;
}

$type = trim((string)($_POST['type'] ?? ''));
$nom = trim((string)($_POST['nom'] ?? ''));
$commentaire = trim((string)($_POST['commentaire'] ?? ''));
$prix_raw = trim((string)($_POST['prix'] ?? ''));

$_SESSION['old'] = [
    'type' => $type,
    'nom' => $nom,
    'commentaire' => $commentaire,
    'prix' => $prix_raw,
];

$errors = [];

if ($type === '') {
    $errors[] = 'Le type est requis.';
}
if ($nom === '') {
    $errors[] = 'Le nom est requis.';
}
if ($prix_raw === '') {
    $errors[] = 'Le prix est requis.';
} else {
    $prix_normalized = str_replace(',', '.', $prix_raw);
    if (!is_numeric($prix_normalized)) {
        $errors[] = 'Le prix doit être un nombre (ex : 3.50).';
    } else {
        $prix_val = floatval($prix_normalized);
    }
}

if (!empty($errors)) {
    foreach ($errors as $e) {
        $_SESSION['flash'][] = ['type' => 'error', 'message' => $e];
    }
    header('Location: /ue/admin/produit_.php');
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO produit ( `type`, `nom`, `commentaire`, `prix`) VALUES ( :type, :nom, :commentaire, :prix)');
    $stmt->execute([
        ':type' => $type,
        ':nom' => $nom,
        ':commentaire' => $commentaire,
        ':prix' => $prix_val,
    ]);

    $_SESSION['flash'][] = ['type' => 'success', 'message' => 'Produit ajouté avec succès.'];
    unset($_SESSION['old']);
} catch (Exception $e) {
    error_log('produit_ajouter error: ' . $e->getMessage());
    $_SESSION['flash'][] = ['type' => 'error', 'message' => 'Erreur lors de l\'ajout du produit (voir logs serveur).'];
}

header('Location: /ue/admin/produit_.php');
exit;