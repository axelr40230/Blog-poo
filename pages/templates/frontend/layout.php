<?php
use App\App;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>

    <link rel="shortcut icon" href="<?= App::url('') ?>public/images/favicon.ico" type="image/x-icon">



    <!-- style -->

    <link href="<?= App::url('') ?>public/css/style.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- style -->

    <!-- bootstrap -->

    <link href="<?= App::url('') ?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- responsive -->

    <link href="<?= App::url('') ?>public/css/responsive.css" rel="stylesheet" type="text/css">

    <!-- font-awesome -->

    <link href="<?= App::url('') ?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- font-awesome -->

    <link href="<?= App::url('') ?>public/css/effects/set2.css" rel="stylesheet" type="text/css">

    <link href="<?= App::url('') ?>public/css/effects/normalize.css" rel="stylesheet" type="text/css">

    <link href="<?= App::url('') ?>public/css/effects/component.css" rel="stylesheet" type="text/css" >

</head>

<body>
<?php require 'header.php';
?>
<?= $content ?>

<?php require('footer.php'); ?>
</body>
</html>

