<?php
include __DIR__ . "/../reutiliser/head.php";
?>

<div class="hori">
    <form class="centre_l centre_h" action="/ue/compte/f_rechercher.php" method="POST">
        <br>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br>
        <label for="password">Mot de passe:</label>
        <input type="text" id="password" name="password" required><br>
        <input type="submit" class="color_r" value="Entrer"><br>
    </form>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
</body>
</html>