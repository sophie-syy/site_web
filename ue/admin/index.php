<?php
include __DIR__ . "/../reutiliser/connecte_sql.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
    header('Location: /ue/index.php');
    exit;
}
include __DIR__ . "/../reutiliser/head.php";
?>
<div class="centre_l">
    <h2 class="_espace">Administration du site</h2>
    <ul>
        <li><a class="non_suligner color_w" 
        href="http://localhost/phpmyadmin/index.php?route=/sql&pos=0&db=ue_compte&table=produit" 
        target="_blank">Gérer les produits</a></li>
        <li><a class="non_suligner color_w" 
        href="http://localhost/phpmyadmin/index.php?route=/sql&pos=0&db=ue_compte&table=users" 
        target="_blank">Gérer les utilisateurs</a></li>
    </ul>
    </body>
    </html>
</div>
