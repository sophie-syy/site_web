<?php include __DIR__ . "/../reutiliser/connecte_sql.php"; 

$email = $_SESSION['user']['email'];

$stmt = $pdo->prepare("DELETE FROM users WHERE email = ?");
$stmt->execute([$email]);

session_unset();
session_destroy();

include __DIR__ ."/../index.php";
exit;
?>