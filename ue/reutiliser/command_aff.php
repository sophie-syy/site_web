<?php
echo '<div class="rectangle">
           <div class="en_ligne"> 
                <img width="80" height="80" src="/ue/image/' . htmlspecialchars($type) . '/' . htmlspecialchars($nom) . '.jpg" alt="">
                    <div class="_espace">
                        <h2>' . htmlspecialchars($type) . ' ' . htmlspecialchars($nom) . '</h2> 
                        <a>' . htmlspecialchars($commentaire) . '</a>
                    </div>
            </div>
            <div class="en_ligne">
                <p class="centre_h">' . htmlspecialchars($prix) . ' €</p>        
                <form class=" _espace" action="/ue/paiment/f_ajouter.php" method="post" target="arriereplan">
                    <input type="hidden" name="product" value="' . $id . '">
                    <input type="number" name="quantite" value="1" min="1" class="input-quantite carre">
                    <input type="submit" class="color_r" value="Ajouter" />
                </form>
            </div>
        </div>';

?>