<?php
require '../app/Autoloader.php';
App\Autoloader::register();

if(isset($_GET['p'])) {
    $p = $_GET['p'];
} else {
    $p ='home';
}
ob_start();
if($p === 'home') {
    $title = 'Accueil';
    require '../pages/home.php';
} elseif ($p === 'single') {
    $title = 'single';
    require '../pages/single.php';
} elseif ($p === 'category') {
    $title = 'Mon blog';
    require '../pages/category.php';
} elseif ($p === 'contact') {
    $title = 'Contact';
    require '../pages/contact.php';
} else {
    $title = 'Erreur 404';
    require '../pages/404.php';
}
$content = ob_get_clean();
require('../pages/templates/layout.php');