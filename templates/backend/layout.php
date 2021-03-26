<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
</head>
<body>

<?php
if(isset($_GET['action'])) :
    $action = htmlspecialchars($_GET['action']);
    if($action != 'login') :
        require_once ('header.php');
    endif;
endif; ?>

<h1><?= $pageTitle ?></h1>

<?= $pageContent ?>

</body>
</html>
