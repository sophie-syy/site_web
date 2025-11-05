<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MIXUE</title>

        <link rel="stylesheet" href="/ue/styles.css">       
    </head>
    
    <body>
        <iframe name="arriereplan" style="display:none;"></iframe>
        <div class="en_ligne">
            <img src="/ue/image/logo.jpg" alt="image" width="80px">
            <form class="centre_h _espace" action="/ue/index.php" method="post">
                <input class="color_w <?php echo ($_SERVER['SCRIPT_NAME'] === '/ue/index.php') ? 'back_color_yes' : 'back_color_no'; ?>" 
                    type="submit" value="Accueil" />
            </form>
            <form class="centre_h _espace" action="/ue/command/p_command.php" method="post">
                <input class="color_w <?php echo (
                    $_SERVER['SCRIPT_NAME'] === '/ue/command/p_command.php' ||
                    $_SERVER['SCRIPT_NAME'] === '/ue/command/p_glace.php' ||
                    $_SERVER['SCRIPT_NAME'] === '/ue/command/p_jus.php' ||
                    $_SERVER['SCRIPT_NAME'] === '/ue/command/p_mousse.php' ||
                    $_SERVER['SCRIPT_NAME'] === '/ue/command/p_new.php' ||
                    $_SERVER['SCRIPT_NAME'] === '/ue/command/p_shake.php' ||
                    $_SERVER['SCRIPT_NAME'] === '/ue/command/p_the.php'
                    ) ? 'back_color_yes' : 'back_color_no'; ?>" 
                    type="submit" value="Command" />
            </form>
            <form class="centre_h _espace" action="/ue/paiment/p_paiment.php" method="post">
                <input class="color_w <?php echo ($_SERVER['SCRIPT_NAME'] === '/ue/paiment/p_paiment.php') ? 'back_color_yes' : 'back_color_no'; ?>" 
                    type="submit" value="Paiement" />
            </form>
            
            <?php include __DIR__ ."/../compte/f_controler.php" ;?>
            
            <?php if (isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin']): ?>
            <form class="centre_h _espace" action="/ue/admin/utilisateur_.php" method="post">
                <input class="color_w <?php echo (
                    $_SERVER['SCRIPT_NAME'] === '/ue/admin/utilisateur_.php' ||
                    $_SERVER['SCRIPT_NAME'] === '/ue/admin/catégories.php' ||
                    $_SERVER['SCRIPT_NAME'] === '/ue/admin/produits.php' ||
                    $_SERVER['SCRIPT_NAME'] === '/ue/admin/utilisateurs.php' 
                    ) ? 'back_color_yes' : 'back_color_no'; ?>" 
                    type="submit" value="Admin" />
            </form>
            <?php endif; ?>
        </div>
