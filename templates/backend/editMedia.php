<?php

// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
header('Location: index.php?action=login');
else :
    ?>

<h2>Envoyer une image depuis votre ordinateur</h2>

<form method="POST" action="?action=upload" enctype="multipart/form-data">

    Fichier : <input type="file" name="media">
    <input type="submit" name="envoyer" value="Envoyer le fichier">
</form>

<?php endif;