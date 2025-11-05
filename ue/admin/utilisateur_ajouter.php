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
    header('Location: /ue/admin/utilisateur_.php');
    exit;
}

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$password = trim((string)($_POST['password'] ?? ''));

$_SESSION['old'] = [
    'name' => $name,
    'email' => $email,
];

$errors = [];

if ($name === '') {
    $errors[] = 'Le nom est requis.';
}
if ($email === '') {
    $errors[] = 'L\'email est requis.';
}
if ($password === '') {
    $errors[] = 'Le mot de passe est requis.';
}

// On ne hash que si il n'y a pas eu d'erreur
if (!empty($errors)) {
    foreach ($errors as $e) {
        $_SESSION['flash'][] = ['type' => 'error', 'message' => $e];
    }
    header('Location: /ue/admin/utilisateur_.php');
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :password_hash)');
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password_hash' => $password_hash,
    ]);

    $_SESSION['flash'][] = ['type' => 'success', 'message' => 'Utilisateur ajouté avec succès.'];
    unset($_SESSION['old']);
} catch (Exception $e) {
    error_log('utilisateur_ajouter error: ' . $e->getMessage());
    $_SESSION['flash'][] = ['type' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'utilisateur.'];
}

header('Location: /ue/admin/utilisateur_.php');
exit;