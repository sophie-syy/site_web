<?php include __DIR__ . "/../reutiliser/connecte_sql.php"; 

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $passwordInput = $_POST['password'] ?? '';

    if ($nom === '' || $email === '' || $passwordInput === '') {
        $errors[] = "Tous les champs sont requis.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE name = ? AND email = ?");
        $stmt->execute([$nom, $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($passwordInput, $user['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nom' => $user['name'],
                'email' => $user['email'],
                'is_admin' => $user['is_admin'],
            ];
            include __DIR__ ."/p_compte.php";
        } else {
            $errors[] = "Compte inconnu ou mot de passe incorrect.";
        }
    }
}
?>

<?php include __DIR__ . "/p_connecter.php"; ?>

