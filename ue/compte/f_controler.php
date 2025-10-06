<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    echo '<form class="centre_h _espace" action="/ue/compte/p_compte.php" method="post">';
    echo '<input class="color_w ' . (($_SERVER['SCRIPT_NAME'] === '/ue/compte/p_compte.php') ?  
    'back_color_yes' : 'back_color_no') . '"type="submit" value="Mon compte" />';
    echo '</form>';
} else {
    echo '<form class="centre_h _espace" action="/ue/compte/p_connecter.php" method="post">';
    echo '<input class="color_w ' 
    . (($_SERVER['SCRIPT_NAME'] === '/ue/compte/p_connecter.php'|| 
        $_SERVER['SCRIPT_NAME'] === '/ue/compte/f_rechercher.php'||
        $_SERVER['SCRIPT_NAME'] === '/ue/compte/f_enregiste.php' 
        ) ? 
        'back_color_yes' : 'back_color_no') . '" type="submit" value="Connecter" />';
    echo '</form>';

    echo '<form class="centre_h _espace" action="/ue/compte/p_creer.php" method="post">';
    echo '<input class="color_w ' 
    . (($_SERVER['SCRIPT_NAME'] === '/ue/compte/p_creer.php') ? 'back_color_yes' : 'back_color_no') . 
    '" type="submit" value="Créer" />';
    echo '</form>';
}
?>